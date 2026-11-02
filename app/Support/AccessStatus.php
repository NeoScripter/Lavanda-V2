<?php

declare(strict_types=1);

namespace Support;

use DateInterval;
use DateTime;
use DB\SQL;
use Enums\AppEnv;
use Enums\ClockMode;
use Enums\PlanSlug;
use Enums\UserRole;
use Http\Models\Access;
use Http\Models\Notification;
use Http\Models\User;
use Jobs\SendEmailJob;
use View;

final class AccessStatus extends \Prefab
{
    private string $clock = 'now';
    private SQL $db;

    function __construct()
    {
        $this->db = \Base::instance()->get('DB');
    }

    public static function set_clock(ClockMode $mode, ?string $interval = 'now'): void
    {
        self::instance()->clock = match ($mode) {
            ClockMode::BACK => new DateTime()->sub(new DateInterval($interval))->format('Y-m-d'),
            ClockMode::FORWARD => new DateTime()->add(new DateInterval($interval))->format('Y-m-d'),
            ClockMode::RESET => 'now',
        };
    }

    public static function has_active_subscription(array $user): bool
    {
        $date = self::instance()->clock;

        $rows = self::instance()->db->exec(
            "SELECT EXISTS ( SELECT 1 FROM accesses a WHERE a.user = ? AND a.subscription_ends_at > ?) AS exists",
            [$user['id'], new DateTime($date)->format('Y-m-d H:i:s')]
        );

        if ($rows[0]['exists']) {
            return true;
        }

        return false;
    }

    public static function has_purchased_games(array $user): bool
    {
        $rows = self::instance()->db->exec(
            "SELECT EXISTS ( SELECT 1 FROM accesses a WHERE a.user = ? AND a.active_games > 0) AS exists",
            [$user['id']]
        );

        if ($rows[0]['exists']) {
            return true;
        }

        return false;
    }

    public static function has_purchased_consultations(array $user): bool
    {
        $rows = self::instance()->db->exec(
            "SELECT EXISTS ( SELECT 1 FROM accesses a WHERE a.user = ? AND a.active_consultations > 0) AS exists",
            [$user['id']]
        );

        if ($rows[0]['exists']) {
            return true;
        }

        return false;
    }

    public static function has_active_plans(array $user): bool
    {
        $date = self::instance()->clock;

        $rows = self::instance()->db->exec(
            "SELECT EXISTS ( SELECT 1 FROM accesses a WHERE s.user = ? AND (a.subscription_ends_at > ? OR a.active_games > 0 OR a.active_consultations > 0)) AS exists",
            [$user['id'], new DateTime($date)->format('Y-m-d H:i:s')]
        );
        return (! empty($rows[0]['exists']));
    }

    public static function list_plans(array $user): array
    {
        $hive = \Base::instance();
        $plans = [];

        $access = new Access();
        $access->load(['user = ?', [$user['id']]]);
        $today = self::instance()->clock;

        if (isset($access->subscription_ends_at) && (new DateTime($access->subscription_ends_at) > new DateTime($today))) {
            $is_above_year = (new DateTime($access->subscription_ends_at)) > (new DateTime($today)->add(new DateInterval('P1Y')));

            $label = '«' . ($is_above_year ? PlanSlug::YEARLY : PlanSlug::MONTHLY)->label() . '»';
            $date = new DateTime($access->subscription_ends_at)->format('d/m/y');
            $plans[] = "{$hive->get("web.тариф")} $label, {$hive->get("web.оплачен_до")} $date";
        }

        if ($access->active_games > 0) {
            $label = '«' . PlanSlug::ONE_TIME->label() . '»';
            $plans[] = "{$hive->get("web.тариф")} $label, {$hive->get("web.в_наличии")} {$access->active_games} {$hive->get("web.ответа")}";
        }

        if ($access->active_consultations > 0) {
            $label = '«' . PlanSlug::PERSONAL->label() . '»';
            $plans[] = "{$hive->get("web.тариф")} $label, {$hive->get("web.в_наличии")} {$access->active_consultations} {$hive->get("web.консультации")}";
        }

        if (empty($plans)) {
            $plans[] = $hive->get("web.у_вас_нет_активных_тарифов");
        }

        return $plans;
    }

    public static function is_admin(array $user): bool
    {
        return $user['role'] === UserRole::ADMIN->value;
    }

    public static function can_play_game(array $user): bool
    {
        $date = self::instance()->clock;

        $rows = self::instance()->db->exec(
            "SELECT EXISTS ( SELECT 1 FROM accesses a WHERE s.user = ? AND (a.subscription_ends_at > ? OR a.active_games > 0)) AS exists",
            [$user['id'], new DateTime($date)->format('Y-m-d H:i:s')]
        );

        return self::instance()->is_admin($user) || (! empty($rows[0]['exists']));
    }

    public static function subtract_consultation(array $user): void
    {
        if (self::instance()->is_admin($user)) {
            return;
        }

        self::instance()->db->exec(
            "UPDATE accesses SET active_consultations = active_consultations - 1 WHERE a.user = ?",
            [$user['id']]
        );
    }

    public static function subtract_game(array $user): void
    {
        if (self::instance()->is_admin($user) || self::instance()->has_active_subscription($user)) {
            return;
        }

        self::instance()->db->exec(
            "UPDATE accesses a SET active_games = active_games - 1 WHERE a.user = ?",
            [$user['id']]
        );
    }

    public static function notify_about_purchase(PlanSlug $slug, array $user): void
    {
        $hive = \Base::instance();

        $buyer = new User();
        $buyer->load(['id = ?', $user['id']]);
        $notification = new Notification();
        $content = [$hive->get('web.покупка_прошла_успешно'), $hive->get('web.доступ_к_платным_разделам_сайта_открыт')];
        $access = $buyer->access;
        $job = new SendEmailJob();

        $subject = '';
        $html = '';

        switch ($slug) {
            case PlanSlug::MONTHLY:
                $label = '«' . $slug->label() . '»';
                $date = new DateTime($access->subscription_ends_at)->format('d/m/y');
                $json = "{$hive->get("web.приобретен_тариф")} $label, {$hive->get("web.оплачен_до")} $date";
                $content[] = $json;

                $subject = $hive->get('web.подтверждение_оплаты_тарифа_от_lavanda_kim');
                $html = View::instance()->render("pages/email/purchased-plan.php", "text/html", [
                    'name' => $user['name'],
                    'html' => $json
                ]);
                break;
            case PlanSlug::YEARLY:
                $label = '«' . $slug->label() . '»';
                $date = new DateTime($access->subscription_ends_at)->format('d/m/y');
                $json = "{$hive->get("web.приобретен_тариф")} $label, {$hive->get("web.оплачен_до")} $date";
                $content[] = $json;

                $subject = $hive->get('web.подтверждение_оплаты_тарифа_от_lavanda_kim');
                $html = View::instance()->render("pages/email/purchased-plan.php", "text/html", [
                    'name' => $user['name'],
                    'html' => $json
                ]);
                break;
            case PlanSlug::ONE_TIME:
                $label = '«' . $slug->label() . '»';
                $json = "{$hive->get("web.приобретен_тариф")} $label, {$hive->get("web.в_наличии")} {$access->active_games} {$hive->get("web.ответа")}";
                $content[] = $json;

                $subject = $hive->get('web.подтверждение_оплаты_тарифа_от_lavanda_kim');
                $html = View::instance()->render("pages/email/purchased-plan.php", "text/html", [
                    'name' => $user['name'],
                    'html' => $json
                ]);
                break;
            case PlanSlug::PERSONAL:
                $label = '«' . $slug->label() . '»';
                $content[] = "{$hive->get("web.приобретен_тариф")} $label, {$hive->get("web.в_наличии")} {$access->active_consultations} {$hive->get("web.ответа")}";
                $subject = $hive->get('web.персональный_разбор');
                $html = View::instance()->render("pages/email/purchased-consultation.php", "text/html", [
                    'name' => $user['name']
                ]);

                break;
        }

        $notification->content = $content;
        $notification->user = $buyer;
        $notification->save();

        if (AppEnv::is(AppEnv::PRODUCTION)) {

            $payload = [
                'subject' => $subject,
                'html' => $html,
                'user_name' => $user['name'],
                'user_email' => $user['email']
            ];

            $job->handle($payload);
        }
    }

    public static function give(PlanSlug $slug, array $user): void
    {
        $current_user = new User();
        $current_user->load(['id = ?', $user['id']]);
        $access = $current_user->access;

        switch ($slug) {
            case PlanSlug::MONTHLY:
            case PlanSlug::YEARLY: {
                    $interval = ($slug === PlanSlug::MONTHLY) ? 'P1M' : 'P1Y';

                    $date = self::instance()->clock;
                    $now = new DateTime($date);

                    if (empty($access)) {
                        $new_date = $now->add(new DateInterval($interval))->format('Y-m-d H:i:s');

                        $new_access = new Access();
                        $new_access->subscription_ends_at = $new_date;
                        $new_access->user = $current_user;
                        $new_access->save();
                    } else {
                        $ends_at = new DateTime($access->subscription_ends_at);

                        if ($ends_at < $now) {
                            $ends_at = $now;
                        }

                        $ends_at = $ends_at->add(new DateInterval($interval))->format('Y-m-d H:i:s');

                        $access->subscription_ends_at = $ends_at;
                        $access->save();
                    }
                };
                break;
            case PlanSlug::ONE_TIME: {
                    if (empty($access)) {
                        $new_access = new Access();
                        $new_access->active_games = 3;
                        $new_access->user = $current_user;
                        $new_access->save();
                    } else {
                        $access->active_games = $access->active_games + 3;
                        $access->save();
                    }
                };
                break;
            case PlanSlug::PERSONAL: {
                    if (empty($access)) {
                        $new_access = new Access();
                        $new_access->active_consultations = 1;
                        $new_access->user = $current_user;
                        $new_access->save();
                    } else {
                        $access->active_consultations = $access->active_consultations + 1;
                        $access->save();
                    }
                };
                break;
        }
    }
}

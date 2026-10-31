<?php

declare(strict_types=1);

namespace Support;

use DateInterval;
use DateTime;
use DB\SQL;
use Enums\ClockMode;
use Enums\PlanSlug;
use Enums\UserRole;
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
            "SELECT EXISTS ( SELECT 1 FROM subscriptions s WHERE s.user = ? AND s.ends_at > ?) AS exists",
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
            "SELECT EXISTS ( SELECT 1 FROM games g WHERE g.user = ? AND g.number > 0) AS exists",
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
            "SELECT EXISTS ( SELECT 1 FROM consultations c WHERE c.user = ? AND c.number > 0) AS exists",
            [$user['id']]
        );

        if ($rows[0]['exists']) {
            return true;
        }

        return false;
    }

    public static function has_active_plans(array $user): bool
    {
        return self::instance()->has_active_subscription($user) ||
            self::instance()->has_purchased_consultations($user) ||
            self::instance()->has_purchased_games($user);
    }

    public static function get_accessed_plans_num(array $user): int
    {
        return 6;
    }

    public static function list_plans(array $user): array
    {
        $hive = \Base::instance();
        $plans = [];

        if (self::instance()->has_active_subscription($user)) {
            $rows = self::instance()->db->exec(
                "SELECT plan_slug, ends_at FROM subscriptions s WHERE s.user = ?",
                [$user['id']]
            );

            $label = '«' . PlanSlug::from($rows[0]['plan_slug'])->label() . '»';
            $date = new DateTime($rows[0]['ends_at'])->format('d/m/y');
            $plans[] = "{$hive->get("web.тариф")} $label, {$hive->get("web.оплачен_до")} $date";
        }

        if (self::instance()->has_purchased_games($user)) {
            $rows = self::instance()->db->exec(
                "SELECT plan_slug, number FROM games g WHERE g.user = ?",
                [$user['id']]
            );

            $label = '«' . PlanSlug::from($rows[0]['plan_slug'])->label() . '»';
            $number = $rows[0]['number'];
            $plans[] = "{$hive->get("web.тариф")} $label, {$hive->get("web.в_наличии")} $number {$hive->get("web.ответа")}";
        }

        if (self::instance()->has_purchased_consultations($user)) {
            $rows = self::instance()->db->exec(
                "SELECT plan_slug, number FROM consultations c WHERE c.user = ?",
                [$user['id']]
            );

            $label = '«' . PlanSlug::from($rows[0]['plan_slug'])->label() . '»';
            $number = $rows[0]['number'];
            $plans[] = "{$hive->get("web.тариф")} $label, {$hive->get("web.в_наличии")} $number {$hive->get("web.консультации")}";
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
        return self::instance()->is_admin($user) || self::instance()->has_active_subscription($user) || self::instance()->has_purchased_games($user);
    }

    public static function subtract_consultation(array $user): void
    {
        if (self::instance()->is_admin($user)) {
            return;
        }

        self::instance()->db->exec(
            "UPDATE consultations SET number = number - 1 WHERE consultations.user = ?",
            [$user['id']]
        );
    }

    public static function subtract_game(array $user): void
    {
        if (self::instance()->is_admin($user) || self::instance()->has_active_subscription($user)) {
            return;
        }

        self::instance()->db->exec(
            "UPDATE games SET number = number - 1 WHERE games.user = ?",
            [$user['id']]
        );
    }

    public static function notify_about_purchase(PlanSlug $slug, array $user): void
    {
        if ($slug === PlanSlug::PERSONAL) {

            $job = new SendEmailJob();

            $html = View::instance()->render("pages/email/purchased-consultation.php", "text/html", ['name' => $user['name']]);

            $payload = [
                'subject' => \Base::instance()->get('web.персональный_разбор'),
                'html' => $html,
                'user_name' => $user['name'],
                'user_email' => $user['email']
            ];

            $job->handle($payload);
        }
    }

    public static function give(PlanSlug $slug, array $user): void
    {
        switch ($slug) {
            case PlanSlug::MONTHLY:
            case PlanSlug::YEARLY: {
                    self::instance()->db->exec(
                        "DELETE FROM subscriptions WHERE subscriptions.ends_at != (
                            SELECT max(ends_at) FROM subscriptions WHERE subscriptions.user = ?
                        )",
                        [$user['id']]
                    );
                    $interval = ($slug === PlanSlug::MONTHLY) ? 'P1M' : 'P1Y';

                    $rows = self::instance()->db->exec(
                        "SELECT ends_at FROM subscriptions s WHERE s.user = ? LIMIT 1",
                        [$user['id']]
                    );

                    $date = self::instance()->clock;
                    $now = new DateTime($date);

                    if (! isset($rows[0]['ends_at'])) {
                        $new_date = $now->add(new DateInterval($interval))->format('Y-m-d H:i:s');

                        self::instance()->db->exec(
                            'INSERT INTO subscriptions ("plan_slug","ends_at","user") VALUES (?,?,?)',
                            [$slug->value, $new_date, $user['id']]
                        );
                    } else {
                        $ends_at = new DateTime($rows[0]['ends_at']);

                        if ($ends_at < $now) {
                            $ends_at = $now;
                        }

                        $ends_at = $ends_at->add(new DateInterval($interval))->format('Y-m-d H:i:s');

                        self::instance()->db->exec(
                            "UPDATE subscriptions SET plan_slug = ?, ends_at = ? WHERE subscriptions.user = ?",
                            [$slug->value, $ends_at, $user['id']]
                        );
                    }
                };
                break;
            case PlanSlug::ONE_TIME: {
                    self::instance()->db->exec(
                        "DELETE FROM games WHERE games.number != (
                            SELECT max(number) FROM games WHERE games.user = ?
                        )",
                        [$user['id']]
                    );

                    $rows = self::instance()->db->exec(
                        "SELECT number FROM games g WHERE g.user = ? LIMIT 1",
                        [$user['id']]
                    );

                    if (! isset($rows[0]['number'])) {
                        self::instance()->db->exec(
                            'INSERT INTO games ("plan_slug","number","user") VALUES (?,?,?)',
                            [$slug->value, 3, $user['id']]
                        );
                    } else {
                        self::instance()->db->exec(
                            "UPDATE games SET number = number + 3 WHERE games.user = ?",
                            [$user['id']]
                        );
                    }
                };
                break;
            case PlanSlug::PERSONAL: {
                    self::instance()->db->exec(
                        "DELETE FROM consultations WHERE consultations.number != (
                            SELECT max(number) FROM consultations WHERE consultations.user = ?
                        )",
                        [$user['id']]
                    );
                    $rows = self::instance()->db->exec(
                        "SELECT number FROM consultations c WHERE c.user = ? LIMIT 1",
                        [$user['id']]
                    );

                    if (! isset($rows[0]['number'])) {
                        self::instance()->db->exec(
                            'INSERT INTO consultations ("plan_slug","number","user") VALUES (?,?,?)',
                            [$slug->value, 1, $user['id']]
                        );
                    } else {
                        self::instance()->db->exec(
                            "UPDATE consultations SET number = number + 1 WHERE consultations.user = ?",
                            [$user['id']]
                        );
                    }
                };
                break;
        }
    }
}

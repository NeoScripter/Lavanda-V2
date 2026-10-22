<?php

declare(strict_types=1);

namespace Support;

use DateInterval;
use DateTime;
use DB\SQL;
use Enums\PlanSlug;
use Enums\UserRole;

final class AccessStatus extends \Prefab
{
    private SQL $db;

    function __construct()
    {
        $this->db = \Base::instance()->get('DB');
    }

    public static function has_active_subscription(array $user): bool
    {
        $date = \Base::instance()->get('CURRENT_DATE') ?? 'now';

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

    public static function list_plans(array $user): array
    {
        $plans = [];

        if (self::instance()->has_active_subscription($user)) {
            $rows = self::instance()->db->exec(
                "SELECT plan_slug, ends_at FROM subscriptions s WHERE s.user = ?",
                [$user['id']]
            );

            $label = '«' . PlanSlug::from($rows[0]['plan_slug'])->label() . '»';
            $date = new DateTime($rows[0]['ends_at'])->format('d/m/y');
            $plans[] = "Тариф $label, оплачен до $date";
        }

        if (self::instance()->has_purchased_games($user)) {
            $rows = self::instance()->db->exec(
                "SELECT plan_slug, number FROM games g WHERE g.user = ?",
                [$user['id']]
            );

            $label = '«' . PlanSlug::from($rows[0]['plan_slug'])->label() . '»';
            $number = $rows[0]['number'];
            $plans[] = "Тариф $label, в наличии $number ответа";
        }

        if (self::instance()->has_purchased_consultations($user)) {
            $rows = self::instance()->db->exec(
                "SELECT plan_slug, number FROM consultations c WHERE c.user = ?",
                [$user['id']]
            );

            $label = '«' . PlanSlug::from($rows[0]['plan_slug'])->label() . '»';
            $number = $rows[0]['number'];
            $plans[] = "Тариф $label, в наличии $number консультации";
        }

        if (empty($plans)) {
            $plans[] = "У вас нет активных тарифов";
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

    public static function give(PlanSlug $slug, array $user): void
    {
        switch ($slug) {
            case PlanSlug::MONTHLY:
            case PlanSlug::YEARLY: {
                    $interval = ($slug === PlanSlug::MONTHLY) ? 'P1M' : 'P1Y';

                    $rows = self::instance()->db->exec(
                        "SELECT ends_at FROM subscriptions s WHERE s.user = ? LIMIT 1",
                        [$user['id']]
                    );

                    $now = new DateTime(\Base::instance()->get('CURRENT_DATE') ?? 'now');

                    if (empty($rows[0]['ends_at'])) {
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
            case PlanSlug::ONE_TIME: {
                    self::instance()->db->exec(
                        "UPDATE games SET number = number + 3 WHERE games.user = ?",
                        [$user['id']]
                    );
                };
            case PlanSlug::PERSONAL: {
                    self::instance()->db->exec(
                        "UPDATE consultations SET number = number + 1 WHERE consultations.user = ?",
                        [$user['id']]
                    );
                };
        }
    }
}

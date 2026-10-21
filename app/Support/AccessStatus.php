<?php

declare(strict_types=1);

namespace Support;

use DateTime;
use DB\SQL;
use Enums\PlanSlug;

final class AccessStatus extends \Prefab
{
    private SQL $db;

    function __construct()
    {
        $this->db = \Base::instance()->get('DB');
    }

    public static function has_active_subscription(array $user): bool
    {
        $rows = self::instance()->db->exec(
            "SELECT EXISTS ( SELECT 1 FROM subscriptions s WHERE s.user = ? AND s.ends_at > ?) AS exists",
            [$user['id'], new DateTime()->format('Y-m-d H:i:s')]
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
}

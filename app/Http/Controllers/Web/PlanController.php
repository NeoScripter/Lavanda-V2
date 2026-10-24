<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\PlanSlug;
use Http\Controller;
use Http\Models\Plan;
use Support\Auth;
use Support\Session;

class PlanController extends Controller
{
    public function index()
    {
        $locale = Session::get_locale();

        $plans = new Plan();
        $plans = $plans->find(
            ['is_active=?', true],
            ['order' => 'created_at DESC']
        );

        $data = require(APP_DIR . '/ui/data/models/plans.php');

        $items = [];

        foreach ($plans as $plan) {
            $items[] = array_merge(
                $data[$plan['slug']],
                ['name' => PlanSlug::from($plan['slug'])->label(), 'price' => $plan['price'], 'slug' => $plan['slug']]
            );
        }

        view('pages/web/plans', compact('items'));
    }

    public function show(\Base $hive)
    {
        if (empty(Auth::user())) {
            $hive->reroute('@login');
        }

        $slug = $hive->PARAMS['slug'];
        $plan = new Plan();
        $plan->load(['is_active=? AND slug=?', true, $slug]);

        if ($plan->dry()) {
            $hive->reroute('@plans');
        }

        $data = require(APP_DIR . '/ui/data/models/plans.php');

        $item = array_merge(
            $data[$plan['slug']],
            ['name' => PlanSlug::from($plan['slug'])->label(), 'price' => $plan['price'], 'slug' => $plan['slug']]
        );

        view('pages/web/plan', compact('item'));
    }
}

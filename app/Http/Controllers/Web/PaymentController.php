<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\AppEnv;
use Enums\PlanSlug;
use Http\Controller;
use Http\Models\Plan;
use Support\AccessStatus;
use Support\Auth;
use Support\Hmac;

class PaymentController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $request = $hive->POST;

        if (! array_key_exists('slug', $request)) {
            $hive->error(400, 'Slug is missing');
        }

        $slug = $request['slug'];

        if (! PlanSlug::tryFrom($slug)) {
            $hive->error(400, 'Invalid slug');
        }

        $user = Auth::user();

        if (! $user) {
            $hive->error(403, 'Unauthorized');
        }

        $plan = new Plan();
        $plan->load(['slug=?', $slug]);

        if (AppEnv::is(AppEnv::PRODUCTION)) {

            $secret_key = getenv('PRODAMUS_KEY');
            $link_to_form = getenv('PRODAMUS_URL');

            $data = [
                'do' => "pay",
                'order_id' => (string) ($slug . '-' . time()),
                'customer_email' => $user['email'],
                'products' => [
                    [
                        'name' => "{$hive->get("web.тариф")} " . mb_convert_case(PlanSlug::from($slug)->label(), MB_CASE_TITLE, 'UTF-8') . '"',
                        'price' => (string) $plan->price,
                        'quantity' => '1',
                    ]
                ]
            ];

            $data['signature'] = Hmac::create($data, $secret_key);
            $link = sprintf('%s?%s', $link_to_form, http_build_query($data));

            $hive->reroute($link);
        } else {
            AccessStatus::give(PlanSlug::from($slug), $user);

            notify(
                $hive->get("web.покупка_успешно_совершена")
            );
            $hive->reroute('@home');
        }
    }
}

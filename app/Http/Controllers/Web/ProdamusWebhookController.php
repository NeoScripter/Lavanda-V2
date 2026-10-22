<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\Plan;
use Http\Models\User;
use Log;
use Support\Hmac;

class ProdamusWebhookController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $data = $hive->POST;
        $serialized_data_keys = implode(', ', array_keys($data));

        $logger = new Log('prodamus.log');
        $logger->write('Prodamus webhook triggered');

        $required_payload_keys = ['customer_email', 'payment_status', 'order_id', 'order_num'];

        foreach ($required_payload_keys as $key) {
            if (array_key_exists($key, $data)) {
                $logger->write("Error: request payload doesn't contain $key. Available keys are: $serialized_data_keys");
                http_response_code(400);
                exit;
            }
        }

        $headers = $hive->HEADERS;

        if (!isset($headers['Sign'])) {
            $serialized_header_keys = implode(', ', array_keys($headers));
            $logger->write("Error: request headers don't have a signature. Available keys are: $serialized_header_keys");
            http_response_code(400);
            exit;
        }
        $signature = $headers['Sign'];
        $signature = preg_replace('/^Sign:\s*/', '', $signature);

        $secret_key = getenv('PRODAMUS_KEY');

        if (! Hmac::verify($data, $secret_key, $headers['Sign'])) {
            $logger->write("Invalid signature");
            http_response_code(400);
            exit;
        }

        $email = $data['customer_email'];
        $order_id = $data['order_id'];
        $order_num = $data['order_num'];
        $status = $data['payment_status'];

        $plan_slug = explode('-', $order_num)[0] ?? null;

        if ($status !== 'success') {
            $logger->write("Error: payment not successful. Status: $status, order id: $order_id");
            http_response_code(200);
            exit;
        }

        if (!$plan_slug) {
            $logger->write("Error: plan slug missing. Order id: $order_id");
            http_response_code(200);
            exit;
        }

        $user = new User();
        $user->load(['email=?', $email]);

        if ($user->dry()) {
            $logger->write("Error: user not found. Email: $email, order id: $order_id");
            http_response_code(200);
            exit;
        }

        $plan = new Plan();
        $plan->load(['slug=?', $plan_slug]);

        if ($plan->dry()) {
            $logger->write("Error: plan not found. Slug: $plan_slug, order id: $order_id");
            http_response_code(200);
            exit;
        }

        try {
            $db = $hive->get("DB");
            $db->begin();

            // TODO: handle subscription purchase

            $logger->write("Subscription processed successfully. Email: $email order id: $order_id");

            $db->commit();
            http_response_code(200);
        } catch (\Exception $e) {
            $logger->write("Error: failed to process webhook request: {$e->getMessage()}. Email: $email, order id: $order_id");
            http_response_code(200);
            exit;
        }
    }
}

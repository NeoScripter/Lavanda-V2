<?php

declare(strict_types=1);

namespace Jobs;

use Enums\AppEnv;
use Exception;
use Log;
use View;

class SendEmailJob extends Job
{
    public function handle(array $payload): void
    {
        $logger = new Log('error.log');
        $required_payload_keys  = ['subject', 'html', 'user_name', 'user_email'];

        foreach ($required_payload_keys as $key) {
            if (! array_key_exists($key, $payload)) {
                $logger->write("Error: request payload doesn't contain $key.");
                exit;
            }
        }

        $subject = $payload['subject'];
        $to = $payload['user_email'];
        $name = $payload['user_name'];
        $html = $payload['html'];

        try {
            $smtp = new \SMTP(
                host: getenv('SMTP_HOST'),
                port: getenv('SMTP_PORT'),
                scheme: getenv('SMTP_SCHEME'),
                user: getenv('SMTP_USER'),
                pw: getenv('SMTP_PASSWORD'),
            );

            $smtp->set('From',     'Lavanda.Kim <info@lavanda.kim>');
            $smtp->set('Reply-To', 'Lavanda.Kim <info@lavanda.kim>');
            $smtp->set('To',       "$name <$to>");
            $smtp->set('Subject',  $subject);
            $smtp->set('Content-type', 'text/html');

            $smtp->send(View::instance()->render("layouts/email/layout.php", 'text/html', compact('html')));

        } catch (Exception $e) {
            if (! AppEnv::is(AppEnv::TESTING)) {
                $logger->write("Failed sending email: {$e->getMessage()}.");
            }
        }

        if (! AppEnv::is(AppEnv::TESTING)) {
            echo 'Email sent successfully!' . PHP_EOL;
        }
    }
}

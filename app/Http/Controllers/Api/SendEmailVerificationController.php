<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Enums\SessionKey;
use Http\Controller;
use Jobs\SendEmailJob;
use View;

class SendEmailVerificationController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $payload = get_json();
        $user_name = $payload['name'];
        $user_email = $payload['email'];

        if (empty($user_name) || empty($user_email)) {
            send_json(['message' =>  "Invalid user data"], 400);
        }

        $job = new SendEmailJob();

        $otp_code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $html = View::instance()->render("pages/email/send-code.php", "text/html", [
            'name' => $user_name,
            'code' => $otp_code,
        ]);

        $hive->set('SESSION.' . SessionKey::OTP_CODE->value, [
            'expires_at' => time() + (60 * 3),
            'code' => $otp_code
        ]);

        $payload = [
            'subject' => $hive->get('email.подтверждение_электронной_почты'),
            'html' => $html,
            'user_name' => $user_name,
            'user_email' => $user_email
        ];

        $job->handle($payload);

        send_json(['message' => 'Code successfully sent']);
    }
}

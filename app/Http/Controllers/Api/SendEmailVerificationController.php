<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Enums\SessionKey;
use Http\Controller;
use Jobs\SendEmailJob;
use Support\Auth;
use View;

class SendEmailVerificationController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $job = new SendEmailJob();
        $user = Auth::user();

        $otp_code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $html = View::instance()->render("pages/email/send-code.php", "text/html", [
            'name' => $user['name'],
            'code' => $otp_code,
        ]);

        $hive->set('SESSION.' . SessionKey::OTP_CODE->value, [
            'expires_at' => time() + (60 * 3),
            'code' => $otp_code
        ]);

        $payload = [
            'subject' => $hive->get('email.подтверждение_электронной_почты'),
            'html' => $html,
            'user_name' => $user['name'],
            'user_email' => $user['email']
        ];

        $job->handle($payload);

        send_json(['message' => 'Code successfully sent']);
    }
}

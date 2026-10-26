<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

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

        $html = View::instance()->render("pages/email/send-code.php", "text/html", [
            'name' => $user['name'],
            'code' => '232323'
        ]);

        $payload = [
            'subject' => $hive->get('email.подтверждение_электронной_почты'),
            'html' => $html,
            'user_name' => $user['name'],
            'user_email' => $user['email']
        ];

        $job->handle($payload);

        $hive->reroute('profile');
    }
}

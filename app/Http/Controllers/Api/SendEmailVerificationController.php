<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Http\Controller;
use Support\Auth;
use View;

class SendEmailVerificationController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $host = 'localhost';
        $port = 1025;
        $scheme = 'smtp';

        $smtp = new \SMTP(
            host: $host,
            port: $port,
            scheme: $scheme,
        );

        $user = Auth::user();
        $user_name = $user['name'];
        $user_email = $user['email'];

        $smtp->set('From',     'Lavanda.Kim <info@lavanda.kim>');
        $smtp->set('Reply-To', 'Lavanda.Kim <info@lavanda.kim>');
        $smtp->set('To',       "$user_name <$user_email>");
        $smtp->set('Subject',  $hive->get('web.подтверждение_электронной_почты'));
        $smtp->set('Content-type', 'text/html');

        $smtp->send(View::instance()->render(
            "emails/layout.php",
            'text/html',
            ['receiver_name' => 'John', 'html' => '<p>Ваш код подтверждения: </p><h2 style="font-size:30px;font-weight:bold;">255235</h2>']
        ));

        $hive->reroute('profile');
    }
}

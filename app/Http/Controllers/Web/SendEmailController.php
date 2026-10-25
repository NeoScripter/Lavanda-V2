<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use View;

class SendEmailController extends Controller
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

        $smtp->set('From',     'Lavanda <ask@ilyaandreev.dev>');
        $smtp->set('Reply-To', '"' . 'Ilya' . '" <' . 'sange0337@gmail.com' . '>');
        $smtp->set('To',       'Lavanda.Kim <info@lavanda.kim>');
        $smtp->set('Subject',  'Код подтверждения');
        $smtp->set('Content-type', 'text/html');

        $smtp->send(View::instance()->render(
            "emails/layout.php",
            'text/html',
            ['receiver_name' => 'John', 'html' => '<p>Ваш код подтверждения: </p><h2 style="font-size:30px;font-weight:bold;">255235</h2>']
        ));

        $hive->reroute('profile');
    }
}

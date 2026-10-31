<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\UserRole;
use Http\Controller;
use Http\Requests\Web\ConsultationRequest;
use Jobs\SendEmailJob;
use Support\AccessStatus;
use Support\Auth;
use Traits\RequiresAuth;
use View;

class ConsultationController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $user = Auth::user();

        if (! AccessStatus::has_purchased_consultations($user)) {
            $hive->reroute('@home');
        }

        view('pages/web/consultation', ['user' => $user]);
    }

    public function store(\Base $hive)
    {
        $user = Auth::user();

        if (! AccessStatus::has_purchased_consultations($user)) {
            $hive->reroute('@home');
        }

        $request = $this->request(ConsultationRequest::class);

        $job = new SendEmailJob();

        $html = View::instance()->render("pages/email/consultation.php", "text/html", $request->all());

        $rows = $hive->get('DB')->exec(
            "SELECT name, email, role, created_at FROM users WHERE role = ? AND created_at = (SELECT MIN(created_at) FROM users) LIMIT 1",
            [UserRole::ADMIN->value]
        );

        $admin_name = $rows[0]['name'] ?? 'Татьяна';
        $admin_email = $rows[0]['email'] ?? 'info@lavanda.kim';

        $payload = [
            'subject' => "Запрос на персональный разбор",
            'html' => $html,
            'user_name' => $admin_name,
            'user_email' => $admin_email
        ];

        $job->handle($payload);

        AccessStatus::subtract_consultation($user);

        notify("{$hive->get("web.ваш_запрос_на_персональный_разбор_успешно_отправлен_ожидайте_пожалуйста_ответ_на_указанный_емаил_в_течение_ближайших_трех_дней")}");
        $hive->reroute('@home');
    }
}

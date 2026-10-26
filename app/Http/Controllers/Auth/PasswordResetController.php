<?php

declare(strict_types=1);

namespace Http\Controllers\Auth;

use Cache;
use Enums\CacheKey;
use Http\Controller;
use Http\Models\User;
use Http\Requests\Profile\PasswordResetSendRequest;
use Http\Requests\Profile\PasswordResetUpdateRequest;
use Jobs\SendEmailJob;
use Support\Auth;
use View;

class PasswordResetController extends Controller
{
    public function beforeroute(\Base $hive)
    {
        if (Auth::check()) {
            $hive->reroute('@home');
        }
    }

    public function index()
    {
        view('pages/web/password-reset', [
            'heading' => 'Forgot Password',
            'title' => 'Forgot Password',
        ]);
    }

    public function edit(\Base $hive)
    {
        $signature = $hive->GET['signature'] ?? null;

        if (empty($signature) || (! Cache::instance()->exists($signature))) {
            $hive->reroute('@home');
        }

        view('pages/web/password-edit', [
            'heading' => 'Update Password',
            'title' => 'Update Password',
            'signature' => $signature,
        ]);
    }

    public function send(\Base $hive)
    {
        $request = $this->request(PasswordResetSendRequest::class);
        $request->validate();

        $salt = getenv('HASH_SALT');
        $hash = hash_hmac('sha256', $request->input('email'), $salt);

        Cache::instance()->set(key: $hash, val: $request->input('email'), ttl: 60 * 3);

        $href = remove_extra_slashes(getenv('APP_URL'). '/'. $hive->alias('password_reset_edit', [], ['signature' => $hash]));

        $job = new SendEmailJob();

        $html = View::instance()->render("pages/email/password-reset.php", "text/html", compact('href'));

        $payload = [
            'subject' => $hive->get('email.восстановление_пароля'),
            'html' => $html,
            'user_name' => 'Пользователь',
            'user_email' => $request->input('email')
        ];

        $job->handle($payload);

        notify("На указанную вами почту была отправлена ссылка для сброса пароля");
        $hive->reroute('@password_reset_index');
    }

    public function update(\Base $hive)
    {
        $request = $this->request(PasswordResetUpdateRequest::class);
        $request->validate();

        $email = Cache::instance()->get($request->input('signature'));

        if (empty($email)) {
            $request->flash_errors(['password' => 'Signature expired']);
            $request->on_failure();
        }

        $user = new User();
        $user->load(['email = ?', $email]);

        if ($user->dry()) {
            $request->flash_errors(['password' => 'Invalid email']);
            $request->on_failure();
        }

        $user->password = $request->input('password');
        $user->save();

        notify('Пароль успешно изменен!');
        $hive->reroute('@login');
    }
}

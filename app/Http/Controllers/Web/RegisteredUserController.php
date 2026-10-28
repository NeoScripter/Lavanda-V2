<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\SessionKey;
use Http\Controller;
use Http\Models\User;
use Http\Requests\Profile\RegisterUserRequest;
use Support\AccessStatus;
use Support\Auth;

class RegisteredUserController extends Controller
{
    public function index(\Base $hive)
    {
        if (Auth::check()) {
            $hive->reroute('@home');
        }

        view('pages/web/register');
    }

    public function store(\Base $hive)
    {
        if (Auth::check()) {
            $hive->reroute('@home');
        }

        $request = $this->request(RegisterUserRequest::class);

        $user = new User();
        $user->load(["email = ? AND is_deleted = 'TRUE'", $request->input('email')]);

        $actual_code = $request->input('otp_code');
        $stored_code = $hive->get('SESSION.' . SessionKey::OTP_CODE->value);

        if ($stored_code['expires_at'] < time()) {
            $request->flash_errors(['email' => $hive->get('validation.your_otp_code_has_expired')]);
            $hive->reroute('@register');
        }

        if ($actual_code !== $stored_code['code']) {
            $request->flash_errors(['email' => $hive->get('validation.incorrect_otp_code')]);
            $hive->reroute('@register');
        }

        if (!$user->dry()) {
            $user->is_deleted = false;
            $user->password = $request->input('password');
        } else {
            $request->validate();
            $user->copyFrom($request->all());
        }

        $user->save();
        Auth::set_user($user->cast());

        notify("{$hive->get("web.добро_пожаловать")}, {$user->name}");
        $hive->reroute($hive->POST['referrer'] ?? '@home');
    }

    public function destroy(\Base $hive)
    {
        check_csrf($hive->POST);

        $current_user = Auth::user();

        if (AccessStatus::is_admin($current_user)) {
            notify("{$hive->get("web.админа_нельзя_удалить")}");
            $hive->reroute("@home");
        }

        $user = new User();
        $user->load(['email = ?', $current_user['email']]);
        $user->is_deleted = true;
        $user->save();

        Auth::clear();

        notify(qquila1До новых встреч!qquila2
);
        $hive->reroute('/');
    }
}

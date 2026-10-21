<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\User;
use Http\Requests\Profile\LoginRequest;
use Support\Auth;

class AuthSessionController extends Controller
{
    public function index(\Base $hive)
    {
        if (Auth::check()) {
            $hive->reroute('@home');
        }

        view('pages/web/login');
    }

    public function store(\Base $hive)
    {
        if (Auth::check()) {
            $hive->reroute('@home');
        }

        $request = $this->request(LoginRequest::class);
        $user = new User();
        $user->load(["email = ? AND is_deleted = 'TRUE'", $request->input('email')]);

        if (!$user->dry()) {
            $request->flash_errors(['email' => $hive->get('admin.these_credentials_dont_match_our_records')]);
            $request->on_failure();
            exit;
        }

        $request->validate();

        $user->load(['email=?', $request->input('email')]);

        if ($user->dry() || !password_verify($request->input('password'), $user->password)) {
            set_values(['email' => $hive->POST['email']]);
            set_errors(['email' =>  $hive->get("admin.these_credentials_dont_match_our_records")]);
            $hive->reroute('@login');
        }

        Auth::set_user($user->cast());

        // notify("{$hive->get("admin.welcome")}, {$user->name}");

        $hive->reroute($hive->POST['referrer'] ?? '@home');
    }

    public function destroy(\Base $hive)
    {
        check_csrf($hive->POST);

        Auth::clear();
        $hive->reroute('/');
    }
}

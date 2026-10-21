<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\User;
use Http\Requests\Profile\RegisterUserRequest;
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
        // TODO: add email verification

        if (!$user->dry()) {
            $user->is_deleted = false;
        } else {
            $request->validate();
            $user->copyFrom($request->all());
        }

        $user->save();
        Auth::set_user($user->cast());

        // notify("{$hive->get("admin.welcome")}, {$user->name}");
        $hive->reroute($hive->POST['referrer'] ?? '@home');
    }

    public function destroy(\Base $hive)
    {
        check_csrf($hive->POST);

        $user = Auth::user();

        $user = new User();
        $user->load(['email = ?', $user['email']]);
        $user->is_deleted = true;
        $user->save();

        Auth::clear();
        $hive->reroute('/');
    }
}

<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Http\Controller;
use Http\Models\User;
use Http\Requests\UpdatePasswordRequest;
use Support\Auth;

class UpdatePasswordController extends Controller
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

    public function index()
    {
        view('pages/admin/password', [
            'title' => 'Update Password',
        ]);
    }

    public function update(\Base $hive)
    {
        $request = $this->request(UpdatePasswordRequest::class);
        $request->validate();

        $current_user = Auth::user();
        $user = new User();
        $user->load(['email=?', $current_user['email']]);

        if ($user->dry() || !password_verify($hive->POST['current_password'], $user->password)) {
            set_errors(['current_password' =>  "Please enter the correct current password"]);
            $hive->reroute('@password');
        }

        $user->copyFrom(['password' => $request->input('new_password')]);
        $user->save();

        notify("Password updated successfully!");
        $hive->reroute('@password');
    }
}

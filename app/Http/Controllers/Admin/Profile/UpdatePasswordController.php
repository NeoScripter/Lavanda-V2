<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\Profile;

use Enums\UserRole;
use Http\Controller;
use Http\Models\User;
use Http\Requests\Profile\UpdatePasswordRequest;
use Support\auth;
use Traits\RequiresAuth;

class UpdatePasswordController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $user = Auth::user();

        if ($user['role'] !== UserRole::ADMIN->value) {
            $hive->reroute('@admin_login');
        }

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
            set_errors(['current_password' =>  $hive->get("admin.please_enter_the_correct_current_password")]);
            $hive->reroute('@password');
        }

        $user->copyFrom(['password' => $request->input('new_password')]);
        $user->save();

        notify($hive->get("admin.password_updated_successfully"));

        $redirect_route = $user['role'] === UserRole::ADMIN->value ? '@password' : '@profile';
        $hive->reroute($redirect_route);
        // $hive->reroute('@password');
    }
}

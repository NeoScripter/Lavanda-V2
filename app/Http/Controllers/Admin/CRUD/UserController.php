<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\PlanSlug;
use Enums\UserRole;
use Exception;
use Http\Controller;
use Http\Models\User;
use Support\AccessStatus;
use Traits\RequiresAdminRights;

class UserController extends Controller
{
    use RequiresAdminRights;

    public function index()
    {
        $users = new User();
        $users = $users->find(
            ['role != ?', UserRole::ADMIN->value],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/users/index', [
            'title' => 'All users',
            'users' => $users,
        ]);
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $user = new User();
        $user->load(['id = ?', $id]);
        $plans = AccessStatus::list_plans([...$user->cast(), 'id' => $user->id]);

        view('pages/admin/users/edit', [
            'title' => 'users',
            'user' => $user,
            'plans' => $plans,
        ]);
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $slug = PlanSlug::from($hive->POST['slug']);

        $user = new User();
        $user->load(['id = ?', $id]);

        if ($user->dry()) {
            throw new Exception('User not found');
        }
        $user_data = [...$user->cast(), 'id' => $user->id];

        AccessStatus::give($slug, $user_data);
        AccessStatus::notify_about_purchase($slug, $user_data);

        notify($hive->get('admin.user_successfully_updated'));

        $hive->reroute("@admin_users_edit(@id=$id)");
    }
}

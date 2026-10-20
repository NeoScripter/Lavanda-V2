<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\User;
use Http\Requests\Profile\UpdateProfileRequest;
use Support\Auth;
use Traits\RequiresAuth;

class ProfileController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $user = Auth::user();

        set_values(['email' => $user['email'], 'name' => $user['name']]);

        view('pages/web/profile');
    }

    public function update(\Base $hive)
    {
        $request = $this->request(UpdateProfileRequest::class);
        $request->validate();

        $current_user = Auth::user();

        $user = new User();
        $user->load(['email=?', $current_user['email']]);
        $user->copyFrom($request->all());
        $user->save();

        Auth::set_user($user->cast());

        notify($hive->get('admin.user_successfully_updated'));
        $hive->reroute('@profile');
    }
}

<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\SessionKey;
use Http\Controller;
use Http\Models\User;
use Http\Requests\Profile\UpdateUserProfileRequest;
use Support\AccessStatus;
use Support\Auth;
use Traits\RequiresAuth;

class ProfileController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $user = Auth::user();

        if (AccessStatus::is_admin($user)) {
            $hive->reroute('@home');
        }
        $plans = AccessStatus::list_plans($user);

        set_values(['email' => $user['email'], 'name' => $user['name']]);

        view('pages/web/profile', compact('plans'));
    }

    public function update(\Base $hive)
    {
        $request = $this->request(UpdateUserProfileRequest::class);
        $current_user = Auth::user();

        if ($current_user['email'] !== $request->input('email')) {
            $actual_code = $request->input('otp_code');
            $stored_code = $hive->get('SESSION.' . SessionKey::OTP_CODE->value);

            if ($stored_code['expires_at'] < time()) {
                $request->flash_errors(['email' => $hive->get('validation.your_otp_code_has_expired')]);
                $hive->reroute('@profile');
            }

            if ($actual_code !== $stored_code['code']) {
                $request->flash_errors(['email' => $hive->get('validation.incorrect_otp_code')]);
                $hive->reroute('@profile');
            }
        }

        $request->validate();

        $user = new User();
        $user->load(['email=?', $current_user['email']]);
        $user->copyFrom($request->all());
        $user->save();

        Auth::set_user($user->cast());

        notify($hive->get('admin.user_successfully_updated'));
        $hive->reroute('@profile');
    }
}

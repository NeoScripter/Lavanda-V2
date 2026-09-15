<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\Profile;

use Http\Controller;
use Http\Requests\Profile\UpdateLocaleRequest;
use Traits\RequiresAuth;

class LocaleController extends Controller
{
    use RequiresAuth;

    public function index()
    {
        view('pages/admin/locale', [
            'title' => 'Language',
        ]);
    }

    public function update(\Base $hive)
    {
        $request = $this->request(UpdateLocaleRequest::class);
        $request->validate();

        $hive->set('COOKIE.locale', $request->input('locale'));
        $hive->reroute('@locale');
    }
}

<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Http\Controller;
use Http\Requests\UpdateLocaleRequest;
use Support\Auth;

class LocaleController extends Controller
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

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

        // dd($request->input('locale'));

        $hive->set('COOKIE.locale', $request->input('locale'));
        $hive->reroute('@locale');
    }
}

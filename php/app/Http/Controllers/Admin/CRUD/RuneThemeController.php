<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Exception;
use Http\Controller;
use Http\Models\Rune;
use Http\Models\RuneTheme;
use Http\Requests\CRUD\RuneTheme\UpdateRuneThemeRequest;
use Traits\RequiresAuth;

class RuneThemeController extends Controller
{
    use RequiresAuth;

    public function edit(\Base $hive)
    {
        $theme_id = $hive->PARAMS['theme_id'];
        $rune_id = $hive->PARAMS['id'];

        $theme = new RuneTheme();
        $theme->load(['id = ?', $theme_id]);

        $rune = new Rune();
        $rune->load(['id = ?', $rune_id]);

        view('pages/admin/rune_themes/edit', [
            'title' => $theme['name'],
            'theme' => $theme,
            'themes' => $rune->themes,
            'rune' => $rune,
        ]);
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['theme_id'];
        $request = $this->request(UpdateRuneThemeRequest::class);
        $request->validate();

        $theme = new RuneTheme();
        $theme->load(['id = ?', $id]);

        if ($theme->dry()) {
            throw new Exception('Rune theme not found');
        }

        $theme->copyFrom($request->all());
        $theme->save();

        $message = "{$hive->get('admin.rune_successfully_updated')}!";

        notify($message);

        $hive->reroute("@admin_rune_themes_edit(@theme_id=$id)");
    }
}

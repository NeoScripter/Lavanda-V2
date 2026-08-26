<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\ThemeableType;
use Exception;
use Http\Controller;
use Http\Models\Theme;
use Http\Requests\CRUD\Theme\StoreThemeRequest;
use Http\Requests\CRUD\Theme\UpdateThemeRequest;
use RuntimeException;
use Traits\RequiresAuth;

class ThemeController extends Controller
{
    use RequiresAuth;

    public function edit(\Base $hive)
    {
        $theme_id = $hive->PARAMS['theme_id'];
        $model_id = $hive->PARAMS['model_id'];
        $model = $hive->PARAMS['model'];

        $theme = new Theme();
        $theme->load(['id = ?', $theme_id]);

        $themeable_type = $this->resolve_themeable_type($model, $model_id);

        view('pages/admin/themes/edit', [
            'title' => $theme['name'],
            'theme' => $theme,
            'themes' => get_unique_themes_by_type($themeable_type, $model_id),
            'model' => $model,
            'model_id' => $model_id,
        ]);
    }

    public function create(\Base $hive)
    {
        $model_id = $hive->PARAMS['model_id'];
        $model = $hive->PARAMS['model'];

        $themeable_type = $this->resolve_themeable_type($model, $model_id);

        view('pages/admin/themes/create', [
            'title' => $hive->get('admin.create_theme'),
            'themes' => get_unique_themes_by_type($themeable_type, $model_id),
            'model' => $model,
            'name' => $hive->GET['name'] ?? '',
            'model_id' => $model_id,
        ]);
    }

    public function store(\Base $hive)
    {
        $model_id = $hive->PARAMS['model_id'];
        $model = $hive->PARAMS['model'];
        $request = $this->request(StoreThemeRequest::class);
        $request->validate();

        $themeable_type = $this->resolve_themeable_type($model, $model_id);

        $theme = new Theme();

        $theme->copyfrom([
            'themeable_type' => $themeable_type->value,
            'themeable_id' => $model_id,
            'name' => $request->input('name'),
            'html' => $request->input('html')
        ]);
        $theme->save();

        notify($hive->get('admin.theme_successfully_created'));

        $hive->reroute(
            $hive->alias(
                'admin_themes_edit',
                ['theme_id' => $theme->id, 'model_id' => $model_id, 'model' => $model]
            )
        );
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['theme_id'];
        $request = $this->request(UpdateThemeRequest::class);
        $request->validate();

        $theme = new Theme();
        $theme->load(['id = ?', $id]);

        if ($theme->dry()) {
            throw new Exception('Theme not found');
        }

        $theme->html = $request->input('html');
        $theme->save();

        notify($hive->get('admin.theme_successfully_updated'));

        $hive->reroute("@admin_themes_edit(@theme_id=$id)");
    }

    private function resolve_themeable_type(string $model, string|int $model_id)
    {
        $db = \Base::instance()->get("DB");

        return match ($model) {
            'runes' => ThemeableType::RUNE,
            'cards' => ThemeableType::from($db->exec(
                'SELECT variant FROM cards WHERE id = ?',
                [$model_id]
            )[0]['variant']),
            default => throw new RuntimeException('Unknown themeable type'),
        };
    }
}

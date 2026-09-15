<?php

$hive = \Base::instance();
$path = $hive->PATH;

extract(component_props(
    required: ['model', 'model_id', 'themes'],
    optional: ['slot' => ''],
    props: get_defined_vars(),
));

$model_name = rtrim($model, 's'); ?>

<div class="flex flex-col space-y-8 xl:flex-row lg:space-y-0 lg:space-x-12">
    <aside class="w-full max-w-xl lg:w-48">

        <?php $is_model_route =  $hive->alias("admin_{$model}_edit", ['id' => $model_id]) === $hive->PATH; ?>
        <?= component('ui/auth-button', [
            'size'    => 'sm',
            'variant' => 'ghost',
            'slot' => mb_ucfirst($hive->get("admin.{$model_name}")),
            'href' => $hive->alias("admin_{$model}_edit", ['id' => $model_id]),
            'class'   => 'relative w-full justify-start ' . ($is_model_route ? 'bg-muted' : ''),
        ]) ?>


        <?= component('ui/heading', [
            'title'       => $hive->get('admin.themes'),
            'description' => $hive->get("admin.select_{$model_name}_theme"),
            'class' => '!my-5 ml-1'
        ]) ?>

        <nav class="flex flex-col space-y-1 space-x-0">
            <?php foreach ($themes as $theme): ?>

                <?php
                $params = array_merge($theme, compact('model', 'model_id'));
                $route = isset($theme['model_id']) ? 'admin_themes_edit' : 'admin_themes_create';
                $query = ['name' => $theme['name']];
                $url = $hive->alias($route, $params, $query);
                $current = $hive->PATH . '?' . $hive->QUERY;
                $is_current_route = $url === $current;
                ?>

                <?= component('ui/auth-button', [
                    'size'    => 'sm',
                    'variant' => 'ghost',
                    'href' => $url,
                    'slot' => mb_ucfirst($theme['name']),
                    'class'   => 'relative w-full justify-start' . ($is_current_route ? ' bg-muted' : ''),
                ]) ?>
            <?php endforeach ?>

            <hr class="my-2" />

            <?php
            $url = $hive->alias('admin_themes_create', compact('model', 'model_id'));
            $is_current_route = ($url === $hive->PATH) && $hive->QUERY === '';
            ?>
            <?= component('ui/auth-button', [
                'size'    => 'sm',
                'variant' => 'ghost',
                'slot' => $hive->get('admin.add_new'),
                'href' => $url,
                'class'   => 'relative w-full justify-start ' . ($is_current_route ? 'bg-muted' : ''),
            ]) ?>

        </nav>
    </aside>

    <hr class="my-6 xl:hidden">

    <div class="flex-1">
        <section>
            <?= $slot ?>
        </section>
    </div>
</div>

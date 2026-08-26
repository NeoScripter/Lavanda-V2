<?php

extract(component_props(
    required: ['model', 'model_id', 'theme', 'themes'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

$title = $hive->get('admin.edit') . ' ' . $hive->get('admin.theme') . ' "' . $theme->name . '"';

slot('layouts/theme-layout', [
    'heading' => $hive->get('admin.runes'),
    'title' => $hive->get('admin.runes'),
    'model' => $model,
    'model_id' => $model_id,
    'themes' => $themes
]); ?>

<div class="space-y-6">

    <?= component('ui/subheading', ['title' => $title]) ?>

    <form action="<?= $hive->alias('admin_themes_update', ['theme_id' => $theme->id]) ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('form/form-wysiwyg', [
            'name'  => 'html',
            'label' => $hive->get('admin.meaning'),
            'attrs' => [
                'required' => true,
                'value'    => $theme->html,
            ],
        ]) ?>

        <div class="flex justify-start gap-4.5">
            <?= component(
                'ui/auth-button',
                [
                    'slot' => $hive->get('admin.save'),
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

<?php

extract(component_props(
    required: ['model', 'model_id', 'themes'],
    optional: ['name' => '', 'layout' => 'admin/app-layout'],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot("layouts/{$layout}", [
    'heading' => $hive->get("admin.{$model}"),
    'title' => $hive->get("admin.{$model}"),
]);
slot('layouts/admin/theme-layout', [
    'model' => $model,
    'model_id' => $model_id,
    'themes' => $themes
]); ?>

<div class="space-y-6">

    <?= component('admin/ui/subheading', ['title' => $hive->get('admin.create_theme')]) ?>

    <form action="<?= $hive->alias('admin_themes_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <?= csrf() ?>

        <?= component('admin/form/form-input', [
            'name'  => 'name',
            'label' => $hive->get('admin.theme_name'),
            'attrs' => [
                'required' => true,
                'value'    => $name,
                'readonly' => $name !== ''
            ],
        ]) ?>

        <?= component('admin/form/form-wysiwyg', [
            'name'  => 'html',
            'label' => $hive->get('admin.meaning'),
            'attrs' => [
                'required' => true,
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
<?php end_slot(); ?>

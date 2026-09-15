<?php

extract(component_props(
    required: ['model', 'model_id', 'theme', 'themes'],
    optional: ['layout' => 'admin-layout'],
    props: get_defined_vars(),
));

$hive = \Base::instance();

$title = $hive->get('admin.edit') . ' ' . $hive->get('admin.theme') . ' "' . $theme->name . '"';
$valid_count = count(array_filter($themes, fn($theme) => isset($theme['theme_id'])));

slot("layouts/{$layout}", [
    'heading' => $hive->get("admin.{$model}"),
    'title' => $hive->get("admin.{$model}"),
]);
slot('layouts/theme-layout', [
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
            <?php if ($valid_count > 1) : ?>
                <?= component('ui/item-actions', [
                    'delete_url' => $hive->alias("admin_themes_destroy", ['id' => $theme->id]),
                    'item_label' => $hive->get('admin.card'),
                ]) ?>
            <?php endif; ?>
        </div>
    </form>


</div>

<?php end_slot(); ?>
<?php end_slot(); ?>

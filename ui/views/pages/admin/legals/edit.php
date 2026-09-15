<?php

extract(component_props(
    required: ['legal'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/admin/item-layout', [
    'heading' => $hive->get('admin.legals'),
    'title' => $hive->get('admin.legals'),
]);?>

<div class="space-y-6">

    <?= component('admin/ui/subheading', ['title' => $hive->get('admin.edit_legal')]) ?>

    <form action="<?= $hive->alias('admin_legals_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('admin/form/form-wysiwyg', [
            'name'  => 'html',
            'label' => $hive->get('admin.content'),
            'attrs' => [
                'required' => true,
                'value'    => $legal['html'],
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
            <?= component(
                'ui/auth-button',
                [
                    'slot' => $hive->get('admin.cancel'),
                    'href' => $hive->alias('admin_legals_index', [], ['variant' => $legal['variant']]),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

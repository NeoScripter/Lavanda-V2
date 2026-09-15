<?php

$hive = \Base::instance();

slot('layouts/item-layout', [
    'heading' => $hive->get('admin.create_stone'),
    'title' => $hive->get('admin.create_stone'),
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $hive->get('admin.create_stone')]) ?>

    <form action="<?= \Base::instance()->alias('admin_stones_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'name',
            'label' => $hive->get('admin.stone_name'),
            'attrs' => [
                'type'     => 'text',
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-wysiwyg', [
            'name'  => 'html',
            'label' => $hive->get('admin.stone_meaning'),
            'attrs' => [
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'image',
            'label' => $hive->get('admin.stone_image'),
            'with_alt' => true,
            'attrs' => [
                'required' => true,
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'preview',
            'label' => $hive->get('admin.stone_preview'),
            'with_alt' => true,
            'attrs' => [
                'required' => true,
                'multiple' => false,
            ],
        ]) ?>

        <div class="flex gap-4.5">
            <?= component('ui/auth-button', [
                'slot' => $hive->get('admin.save'),
                'attrs' => ['type' => 'submit']
            ]) ?>

            <?= component('ui/auth-button', [
                'slot' => $hive->get('admin.cancel'),
                'href' => $hive->alias('admin_stones_index'),
                'variant' => 'secondary',
                'attrs' => ['type' => 'submit']
            ]) ?>

        </div>
    </form>
</div>

<?php end_slot(); ?>

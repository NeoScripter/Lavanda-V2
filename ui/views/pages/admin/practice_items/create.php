<?php

$hive = \Base::instance();

slot('layouts/admin/item-layout', [
    'heading' => $hive->get('admin.practice'),
    'title' => $hive->get('admin.practice'),
]);
?>

<div class="space-y-6">
    <?= component('admin/ui/subheading', ['title' => $hive->get('admin.create_item')]) ?>

    <form action="<?= \Base::instance()->alias('admin_practice_items_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <?= csrf() ?>

        <?= component('admin/form/form-input', [
            'name'  => 'title',
            'label' => $hive->get('admin.item_name'),
            'attrs' => [
                'type'     => 'text',
                'required' => true,
            ],
        ]) ?>

        <?= component('admin/form/form-textarea', [
            'name'  => 'description',
            'label' => $hive->get('admin.item_description'),
            'attrs' => [
                'required' => true,
            ],
        ]) ?>

        <?= component('admin/form/form-file-input', [
            'name'  => 'image',
            'label' => $hive->get('admin.image'),
            'with_alt' => true,
            'attrs' => [
                'required' => true,
                'multiple' => false,
            ],
        ]) ?>

        <?= component('admin/form/form-file-input', [
            'name'  => 'file',
            'label' => $hive->get('admin.file'),
            'with_alt' => true,
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <?= component('admin/form/form-accordion', [
            'name'  => 'faqs',
            'label' => $hive->get('admin.faqs'),
        ]) ?>

        <div class="flex justify-between gap-2.5">
            <?= component('admin/ui/auth-button', [
                'slot' => $hive->get('admin.save'),
                'attrs' => ['type' => 'submit']
            ]) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

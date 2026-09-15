<?php

$hive = \Base::instance();

slot('layouts/item-layout', [
    'heading' => $hive->get('admin.runes'),
    'title' => $hive->get('admin.runes'),
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $hive->get('admin.create_a_rune')]) ?>

    <form action="<?= \Base::instance()->alias('admin_runes_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'name',
            'label' => $hive->get('admin.rune_name'),
            'attrs' => [
                'type'     => 'text',
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-textarea', [
            'name'  => 'advice',
            'label' => $hive->get('admin.rune_advice'),
            'attrs' => [
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'front_image',
            'label' => $hive->get('admin.front_image'),
            'with_alt' => true,
            'attrs' => [
                'required' => true,
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'back_image',
            'label' => $hive->get('admin.back_image'),
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
                'href' => $hive->alias('admin_runes_index'),
                'variant' => 'secondary',
                'attrs' => ['type' => 'submit']
            ]) ?>

        </div>
    </form>
</div>

<?php end_slot(); ?>

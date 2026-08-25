<?php

$hive = \Base::instance();

slot('layouts/card-grid-layout', [
    'heading' => $hive->get('admin.cards'),
    'title' => $hive->get('admin.cards'),
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $hive->get('admin.create_a_card')]) ?>

    <form action="<?= \Base::instance()->alias('admin_cards_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'name',
            'label' => $hive->get('admin.card_name'),
            'attrs' => [
                'type'     => 'text',
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

        <?= component('form/form-textarea', [
            'name'  => 'advice',
            'label' => $hive->get('admin.card_advice'),
            'attrs' => [
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-wysiwyg', [
            'name'  => 'description',
            'label' => $hive->get('admin.card_meaning'),
            'attrs' => [
                'required' => true,
            ],
        ]) ?>

        <div class="flex justify-between gap-2.5">
            <?= component('ui/auth-button', [
                'slot' => $hive->get('admin.save'),
                'attrs' => ['type' => 'submit']
            ]) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

<?php

$hive = \Base::instance(); ?>
<?php slot('layouts/card-layout', [
    'heading' => $hive->get('admin.profile'),
    'title' => $hive->get('admin.profile'),
]); ?>


<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', [
            'title'       => 'Create a card',
            'class'       => "[&>h3,&>p]:animate-none",
        ]) ?>

        <form action="<?= \Base::instance()->alias('admin_cards_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <?= csrf() ?>

            <?= component('form/form-input', [
                'name'  => 'name',
                'label' => 'Card name',
                'attrs' => [
                    'type'     => 'text',
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-file-input', [
                'name'  => 'front_image',
                'label' => 'Front image',
                'with_alt' => true,
                'attrs' => [
                    'required' => true,
                    'multiple' => false,
                ],
            ]) ?>

            <?= component('form/form-textarea', [
                'name'  => 'advice',
                'label' => 'Card advice',
                'attrs' => [
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-wysiwyg', [
                'name'  => 'html',
                'label' => 'Card meaning',
                'attrs' => [
                    'required' => true,
                ],
            ]) ?>

            <div class="flex justify-between gap-2.5">
                <?php slot('components/ui/auth-button', ['attrs' => ['type' => 'submit']]); ?>
                <?= $hive->get('admin.save') ?>
                <?php end_slot(); ?>
            </div>
        </form>
    </div>
</div>

<?php end_slot(); ?>

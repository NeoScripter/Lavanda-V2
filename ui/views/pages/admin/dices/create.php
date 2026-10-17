<?php

$hive = \Base::instance();

slot('layouts/admin/app-layout', [
    'heading' => $hive->get('admin.dices'),
    'title' => $hive->get('admin.dices'),
]);
?>

<div class="space-y-6">
    <?= component('admin/ui/subheading', ['title' => $hive->get('admin.create_dice')]) ?>


    <form action="<?= \Base::instance()->alias('admin_dices_store') ?>" method="post" class="space-y-6 max-w-200" enctype="multipart/form-data">
        <?= csrf() ?>

        <?= component('admin/ui/dice-picker') ?>

        <div class="flex justify-between gap-2.5">
            <?= component('admin/ui/auth-button', [
                'slot' => $hive->get('admin.save'),
                'attrs' => [
                    'type' => 'submit',
                    'disabled' => 'true',
                    'cmp-submit-form-btn' => true
                ]
            ]) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

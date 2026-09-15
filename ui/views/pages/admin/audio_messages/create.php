<?php

$hive = \Base::instance();

slot('layouts/audio-layout', [
    'heading' => $hive->get('admin.audio'),
    'title' => $hive->get('admin.audio'),
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $hive->get('admin.create_audio')]) ?>

    <form action="<?= \Base::instance()->alias('admin_audio_messages_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <?= csrf() ?>

        <?= component('form/form-textarea', [
            'name'  => 'description',
            'label' => $hive->get('admin.audio_description'),
            'attrs' => [
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'file',
            'label' => $hive->get('admin.audio_file'),
            'with_alt' => true,
            'attrs' => [
                'multiple' => false,
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

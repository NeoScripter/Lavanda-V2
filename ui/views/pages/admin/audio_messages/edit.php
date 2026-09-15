<?php

extract(component_props(
    required: ['audio'],
    optional: [],
    props: get_defined_vars(),
));


$hive = \Base::instance();

slot('layouts/item-layout', [
    'heading' => $hive->get('admin.audios'),
    'title' => $hive->get('admin.audios')
]); ?>

<div class="space-y-6">

    <?= component('ui/subheading', ['title' => $hive->get('admin.edit_audio')]) ?>

    <form action="<?= $hive->alias('admin_audio_messages_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('form/form-textarea', [
            'name'  => 'description',
            'label' => $hive->get('admin.audio_description'),
            'attrs' => [
                'value'     => $audio['description'],
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'file',
            'label' => $hive->get('admin.audio_file'),
            'value'    => [$audio['file'] ?? null],
            'with_alt' => false,
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <div class="flex justify-start gap-4.5">
            <?= component(
                'ui/auth-button',
                ['slot' => $hive->get('admin.save'), 'attrs' => ['type' => 'submit']]
            ) ?>
            <?= component(
                'ui/auth-button',
                [
                    'slot' => $hive->get('admin.cancel'),
                    'href' => $hive->alias('admin_audio_messages_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

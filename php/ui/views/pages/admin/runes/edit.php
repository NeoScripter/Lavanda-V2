<?php

extract(component_props(
    required: ['rune', 'themes'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/theme-layout', [
    'heading' => $hive->get('admin.runes'),
    'title' => $hive->get('admin.runes'),
    'model' => 'runes',
    'model_id' => $rune['id'],
    'themes' => $themes
]); ?>

<div class="space-y-6">

    <?= component('ui/subheading', ['title' => $hive->get('admin.edit_rune')]) ?>

    <form action="<?= $hive->alias('admin_runes_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'name',
            'label' => $hive->get('admin.rune_name'),
            'attrs' => [
                'type'     => 'text',
                'value'    => $rune['name'],
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-textarea', [
            'name'  => 'advice',
            'label' => $hive->get('admin.rune_advice'),
            'attrs' => [
                'required' => true,
                'value'    => $rune['advice'],
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'front_image',
            'label' => $hive->get('admin.front_image'),
            'with_alt' => true,
            'can_delete' => false,
            'value'    => [$rune['front_image'] ?? null],
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'back_image',
            'label' => $hive->get('admin.back_image'),
            'with_alt' => true,
            'can_delete' => false,
            'value'    => [$rune['back_image'] ?? null],
            'attrs' => [
                'multiple' => false,
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
                    'href' => $hive->alias('admin_runes_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

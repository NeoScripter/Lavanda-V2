<?php

extract(component_props(
    required: ['card'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/card-grid-layout', [
    'heading' => $hive->get('admin.cards'),
    'title' => $hive->get('admin.cards'),
]); ?>

<div class="space-y-6">

    <?= component('ui/subheading', ['title' => $hive->get('admin.edit_a_card')]) ?>

    <form action="<?= $hive->alias('admin_cards_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'name',
            'label' => $hive->get('admin.card_name'),
            'attrs' => [
                'type'     => 'text',
                'value'    => $card['name'],
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'front_image',
            'label' => $hive->get('admin.front_image'),
            'with_alt' => true,
            'value'    => [$card['front_image'] ?? null],
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-textarea', [
            'name'  => 'advice',
            'label' => $hive->get('admin.card_advice'),
            'attrs' => [
                'required' => true,
                'value'    => $card['advice'],
            ],
        ]) ?>

        <?= component('form/form-wysiwyg', [
            'name'  => 'html',
            'label' => $hive->get('admin.card_meaning'),
            'attrs' => [
                'required' => true,
                'value'    => $card['html'],
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
                    'href' => $hive->alias('admin_cards_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

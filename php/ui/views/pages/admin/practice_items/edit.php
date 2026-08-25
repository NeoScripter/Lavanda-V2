<?php

extract(component_props(
    required: ['item'],
    optional: [],
    props: get_defined_vars(),
));


$hive = \Base::instance();

slot('layouts/item-layout', [
    'heading' => $hive->get('admin.practice'),
    'title' => $hive->get('admin.practice'),
]); ?>

<div class="space-y-6">

    <?= component('ui/subheading', ['title' => $hive->get('admin.edit_item')]) ?>

    <form action="<?= $hive->alias('admin_practice_items_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'title',
            'label' => $hive->get('admin.item_name'),
            'attrs' => [
                'type'     => 'text',
                'value'     => $item['title'],
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-textarea', [
            'name'  => 'description',
            'label' => $hive->get('admin.item_description'),
            'attrs' => [
                'value'     => $item['description'],
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'image',
            'label' => $hive->get('admin.image'),
            'with_alt' => true,
            'value'    => [$item['image'] ?? null],
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'file',
            'label' => $hive->get('admin.file'),
            'value'    => [$item['file'] ?? null],
            'with_alt' => false,
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-accordion', [
            'name'  => 'faqs',
            'value'    => $item['faqs'] ?? [],
            'label' => $hive->get('admin.faqs'),
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
                    'href' => $hive->alias('admin_practice_items_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

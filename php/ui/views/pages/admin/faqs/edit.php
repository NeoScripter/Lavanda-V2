<?php

extract(component_props(
    required: ['faq'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/item-layout', [
    'heading' => $hive->get('admin.faqs'),
    'title' => $hive->get('admin.faqs'),
]); ?>

<div class="space-y-6 max-w-160">
    <div class="flex items-center justify-between gap-4">
        <?= component('ui/subheading', ['title' => $hive->get('admin.edit_faq')]) ?>

        <?= component('ui/item-actions-mini', [
            'delete_url' => $hive->alias("admin_faqs_destroy", ['id' => $faq->id]),
            'item_label' => $hive->get('admin.faq'),
        ]) ?>
    </div>
    <form action="<?= $hive->alias('admin_faqs_update') ?>" method="post" class="space-y-6" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'question',
            'label' => $hive->get('admin.question'),
            'attrs' => [
                'type'     => 'text',
                'value'    => $faq->question,
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-textarea', [
            'name'  => 'answer',
            'label' => $hive->get('admin.answer'),
            'attrs' => [
                'required' => true,
                'value'    => $faq->answer,
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
                    'href' => $hive->alias('admin_faqs_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

<?php

extract(component_props(
    required: ['faq'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/faq-grid-layout', [
    'heading' => $hive->get('admin.faqs'),
    'title' => $hive->get('admin.faqs'),
]); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', ['title' => $hive->get('admin.edit_a_faq')]) ?>

        <form action="<?= $hive->alias('admin_faqs_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="put">
            <?= csrf() ?>

            <?= component('form/form-input', [
                'name'  => 'name',
                'label' => $hive->get('admin.faq_name'),
                'attrs' => [
                    'type'     => 'text',
                    'value'    => $faq['name'],
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-textarea', [
                'name'  => 'advice',
                'label' => $hive->get('admin.faq_advice'),
                'attrs' => [
                    'required' => true,
                    'value'    => $faq['advice'],
                ],
            ]) ?>

            <div class="flex justify-start gap-4.5">
                <?= component(
                    'ui/auth-button',
                    ['slot' => 'Save', 'attrs' => ['type' => 'submit']]
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
</div>

<?php end_slot(); ?>

<?php

use Enums\PlanSlug;

extract(component_props(
    required: ['plan'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/admin/item-layout', [
    'heading' => $hive->get('admin.plans'),
    'title' => $hive->get('admin.plans'),
]); ?>

<div class="space-y-6 max-w-100">
    <div class="flex items-center justify-between gap-4">
        <?= component('admin/ui/subheading', ['title' => $hive->get('admin.edit_plan') . ' «' . PlanSlug::from($plan->slug)->label() . '»']) ?>
    </div>
    <form action="<?= $hive->alias('admin_plans_update') ?>" method="post" class="space-y-6" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('admin/form/form-input', [
            'name'  => 'price',
            'label' => $hive->get('admin.price'),
            'attrs' => [
                'type'     => 'text',
                'placeholder'     => '500',
                'value'    => $plan->price,
            ],
        ]) ?>

        <?= component('admin/form/checkbox', [
            'name'        => 'is_active',
            'label'       => $hive->get('admin.active'),
            'attrs' => ['checked' => $plan->is_active]
        ]) ?>

        <div class="flex justify-start gap-4.5">
            <?= component(
                'admin/ui/auth-button',
                ['slot' => $hive->get('admin.save'), 'attrs' => ['type' => 'submit']]
            ) ?>
            <?= component(
                'admin/ui/auth-button',
                [
                    'slot' => $hive->get('admin.cancel'),
                    'href' => $hive->alias('admin_plans_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

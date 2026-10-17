<?php

extract(component_props(
    required: ['dice'],
    optional: ['themes'],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/admin/app-layout', [
    'heading' => $hive->get('admin.dices'),
    'title' => $hive->get('admin.dices'),
]);
slot('layouts/admin/theme-layout', [
    'model' => 'dices',
    'model_id' => $dice['id'],
    'themes' => $themes
]); ?>

<div class="space-y-6">

    <?= component('admin/ui/subheading', ['title' => $hive->get('admin.edit_dice')]) ?>

    <form action="<?= $hive->alias('admin_dices_update') ?>" method="post" class="space-y-6 max-w-260" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('admin/ui/dice-picker', [
            'diceable_id' => $dice['diceable_id']
        ]) ?>

        <div class="flex justify-start gap-4.5">
            <?= component(
                'admin/ui/auth-button',
                [
                    'slot' => $hive->get('admin.save'),
                    'attrs' => [
                        'type' => 'submit',
                        'cmp-submit-form-btn' => true
                    ]
                ]
            ) ?>
            <?= component(
                'admin/ui/auth-button',
                [
                    'slot' => $hive->get('admin.cancel'),
                    'href' => $hive->alias('admin_dices_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>
<?php end_slot(); ?>

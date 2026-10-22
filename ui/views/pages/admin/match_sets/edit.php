<?php

extract(component_props(
    required: ['match_set', 'images'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/admin/match-set-layout', [
    'heading' => $hive->get('admin.match_sets'),
    'title' => $hive->get('admin.match_sets'),
]); ?>

<div class="space-y-6">

    <?= component('admin/ui/subheading', ['title' => $hive->get('admin.edit_match_set')]) ?>

    <form action="<?= $hive->alias('admin_match_sets_update') ?>" method="post" class="space-y-6 max-w-260" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?php if (! empty($images)) : ?>
            <?= component('admin/ui/match-set-picker', [
                'images' => $images,
                'matcheable_id' => $match_set['matcheable_id']
            ]) ?>
        <?php else: ?>
            <p><?= $hive->get('admin.there_are_no_added_items_yet_to_select_from') ?></p>
        <?php endif; ?>

        <?= component('admin/form/form-textarea', [
            'name'  => 'advice',
            'label' => $hive->get('admin.match_set_advice'),
            'attrs' => [
                'required' => true,
                'value'    => $match_set['advice'],
            ],
        ]) ?>

        <?= component('admin/form/form-wysiwyg', [
            'name'  => 'html',
            'label' => $hive->get('admin.match_set_meaning'),
            'attrs' => [
                'required' => true,
                'value'    => $match_set['html'],
            ],
        ]) ?>

        <div class="flex justify-start gap-4.5">
            <?= component(
                'admin/ui/auth-button',
                [
                    'slot' => $hive->get('admin.save'),
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
            <?= component(
                'admin/ui/auth-button',
                [
                    'slot' => $hive->get('admin.cancel'),
                    'href' => $hive->alias('admin_match_sets_index', [], ['matcheable_type' => $match_set['matcheable_type']]),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

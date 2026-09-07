<?php

$hive = \Base::instance();

extract(component_props(
    required: ['images'],
    optional: [],
    props: get_defined_vars(),
));

slot('layouts/match-set-layout', [
    'heading' => $hive->get('admin.match_sets'),
    'title' => $hive->get('admin.match_sets'),
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $hive->get('admin.create_match_set')]) ?>


    <form action="<?= \Base::instance()->alias('admin_match_sets_store') ?>" method="post" class="space-y-6 max-w-200" enctype="multipart/form-data">
        <?= csrf() ?>

        <?php view('pages/admin/match_sets/partials/item-picker', [
            'images' => $images
        ]); ?>

        <?= component('form/form-textarea', [
            'name'  => 'advice',
            'label' => $hive->get('admin.match_set_advice'),
            'attrs' => [
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-wysiwyg', [
            'name'  => 'html',
            'label' => $hive->get('admin.match_set_meaning'),
            'attrs' => [
                'required' => true,
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

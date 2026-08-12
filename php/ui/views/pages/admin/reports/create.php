<?php slot('layouts/admin-layout', [
    'heading' => 'Reports',
    'title' => 'Reports'
]); ?>

<?php $hive = \Base::instance(); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', [
            'title'       => "Create report",
        ]) ?>

        <form action="<?= $hive->alias('admin_reports_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <?= csrf() ?>

            <?= component('form/form-input', [
                'name'  => 'title',
                'label' => 'Report title',
                'attrs' => [
                    'type'     => 'text',
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-file-input', [
                'name'  => 'src',
                'label' => 'File',
                'attrs' => [
                    'required' => true,
                    'multiple' => false,
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
                        'slot' => 'Cancel',
                        'href' => $hive->alias('admin_reports_index'),
                        'variant' => 'secondary',
                        'attrs' => ['type' => 'submit']
                    ]
                ) ?>
            </div>
        </form>
    </div>
</div>

<?php end_slot(); ?>

<?php slot('layouts/admin-layout', [
    'heading' => 'Reports',
    'title' => 'Reports'
]); ?>

<?php $hive = \Base::instance(); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', [
            'title'       => "Edit $title report",
            'class'       => "[&>h3,&>p]:animate-none",
        ]) ?>

        <form action="<?= $hive->alias('admin_reports_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="put">
            <?= csrf() ?>

            <?= component('form/form-input', [
                'name'  => 'title',
                'label' => 'Report title',
                'attrs' => [
                    'type'     => 'text',
                    'value'    => $report['title'],
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-file-input', [
                'name'  => 'src',
                'label' => 'File',
                'value'    => [$report['src'] ?? []],
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

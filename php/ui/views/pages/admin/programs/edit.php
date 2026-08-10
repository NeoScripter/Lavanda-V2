<?php slot('layouts/admin-layout', [
    'heading' => 'Programs',
    'title' => 'Programs'
]); ?>

<?php $hive = \Base::instance(); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', [
            'title'       => "Edit $title program's gallery",
            'class'       => "[&>h3,&>p]:animate-none",
        ]) ?>

        <form action="<?= $hive->alias('admin_programs_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="put">
            <?= csrf() ?>

            <?= component('form/form-file-input', [
                'name'  => 'gallery',
                'label' => 'Gallery Images',
                'with_alt' => true,
                'value'    => $program['gallery'] ?? [],
                'attrs' => [
                    'required' => false,
                    'multiple' => true,
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
                        'href' => $hive->alias('admin_programs_index'),
                        'variant' => 'secondary',
                        'attrs' => ['type' => 'submit']
                    ]
                ) ?>
            </div>
        </form>
    </div>
</div>

<?php end_slot(); ?>

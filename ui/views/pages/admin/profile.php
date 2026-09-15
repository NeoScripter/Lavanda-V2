<?php $hive = \Base::instance(); ?>
<?php slot('layouts/profile-layout', [
    'heading' => $hive->get('admin.profile'),
    'title' => $hive->get('admin.profile'),
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', [
        'title'       => $hive->get('admin.profile_information'),
        'description' => $hive->get('admin.update_your_name_and_email_address'),
    ]) ?>

    <form action="<?= \Base::instance()->alias('profile_update') ?>" method="post" class="space-y-6">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'name',
            'label' => $hive->get('admin.full_name'),
            'error' => $errors['name'] ?? '',
            'attrs' => [
                'type'     => 'text',
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-input', [
            'name'  => 'email',
            'label' => $hive->get('admin.email_address'),
            'error' => $errors['email'] ?? '',
            'attrs' => [
                'type'     => 'email',
                'required' => true,
            ],
        ]) ?>

        <div class="flex justify-between gap-2.5">
            <?php slot('components/ui/auth-button', ['attrs' => ['type' => 'submit']]); ?>
            <?= $hive->get('admin.save') ?>
            <?php end_slot(); ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

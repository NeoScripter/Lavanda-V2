<?php $hive = \Base::instance(); ?>
<?php slot('layouts/profile-layout', [
    'heading' => $hive->get('admin.password_settings'),
    'title' => $hive->get('admin.password_settings')
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', [
        'title'       => $hive->get('admin.update_password'),
        'description' => $hive->get('admin.ensure_your_account_is_using_a_long_random_password_to_stay_secure'),
    ]) ?>

    <form action="<?= \Base::instance()->alias('password_update') ?>" method="post" class="space-y-6">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'current_password',
            'label' => $hive->get('admin.current_password'),
            'error' => $errors['current_password'] ?? '',
            'attrs' => [
                'type'     => 'password',
                'required' => true,
                'value'    => $values['current_password'] ?? '',
            ],
        ]) ?>

        <?= component('form/form-input', [
            'name'  => 'new_password',
            'label' => $hive->get('admin.new_password'),
            'error' => $errors['new_password'] ?? '',
            'attrs' => [
                'type'     => 'password',
                'required' => true,
                'value'    => $values['new_password'] ?? '',
            ],
        ]) ?>

        <?= component('form/form-input', [
            'name'  => 'password_confirmation',
            'label' => $hive->get('admin.confirm_password'),
            'error' => $errors['password_confirmation'] ?? '',
            'attrs' => [
                'type'     => 'password',
                'required' => true,
                'value'    => $values['password_confirmation'] ?? '',
            ],
        ]) ?>

        <div class="flex justify-between gap-2.5">
            <?php slot('components/ui/auth-button', ['attrs' => ['type' => 'submit']]); ?>
            <?= $hive->get('admin.save_password') ?>
            <?php end_slot(); ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

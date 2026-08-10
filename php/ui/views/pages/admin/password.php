<?php slot('layouts/profile-layout', [
    'heading' => 'Password settings',
    'title' => 'Password settings'
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', [
        'title'       => 'Update password',
        'description' => 'Ensure your account is using a long, random password to stay secure',
        'class'       => "[&>h3,&>p]:animate-none",
    ]) ?>

    <form action="<?= \Base::instance()->alias('password_update') ?>" method="post" class="space-y-6">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'current_password',
            'label' => 'Current password',
            'error' => $errors['current_password'] ?? '',
            'attrs' => [
                'type'     => 'password',
                'required' => true,
                'value'    => $values['current_password'] ?? '',
            ],
        ]) ?>

        <?= component('form/form-input', [
            'name'  => 'new_password',
            'label' => 'New password',
            'error' => $errors['new_password'] ?? '',
            'attrs' => [
                'type'     => 'password',
                'required' => true,
                'value'    => $values['new_password'] ?? '',
            ],
        ]) ?>

        <?= component('form/form-input', [
            'name'  => 'password_confirmation',
            'label' => 'Confirm password',
            'error' => $errors['password_confirmation'] ?? '',
            'attrs' => [
                'type'     => 'password',
                'required' => true,
                'value'    => $values['password_confirmation'] ?? '',
            ],
        ]) ?>

        <div class="flex justify-between gap-2.5">
            <?php slot('components/ui/auth-button', ['attrs' => ['type' => 'submit']]); ?>
            Save password
            <?php end_slot(); ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

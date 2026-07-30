<?php slot('layouts/auth-layout', [
    'heading' => 'Log in to your account',
    'description' => 'Enter your email and password below to log in',
    'title' => 'Login'
]); ?>

<?php $hive = \Base::instance(); ?>

<form action="<?= $hive->alias("login") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <?= csrf() ?>

    <?= component('form/form-input', [
        'name'        => 'email',
        'label'       => 'Email address',
        'attrs' => [
            'type'        => 'email',
            'placeholder' => 'email@example.com',
            // 'required'    => true,
        ]
    ]) ?>

    <?= component('form/form-input', [
        'name'        => 'password',
        'label'       => 'Password',
        'placeholder' => 'Enter your password',
        'attrs' => [
            'type'        => 'password',
            'placeholder' => 'Enter your password',
            // 'required'    => true,
        ]
    ]) ?>

    <div class="flex justify-between gap-2.5">
        <?php slot('components/ui/auth-button', ['attrs' => ['type' => 'submit']]); ?>
        Log in
        <?php end_slot(); ?>
    </div>

</form>

<?php end_slot(); ?>

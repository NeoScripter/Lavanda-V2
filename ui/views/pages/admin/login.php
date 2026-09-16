<?php $hive = \Base::instance(); ?>

<?php slot('layouts/admin/auth-layout', [
    'heading' => $hive->get('admin.log_in_to_your_account'),
    'description' => $hive->get('admin.enter_your_email_and_password_below_to_log_in'),
    'title' => $hive->get('admin.login')
]); ?>

<form action="<?= $hive->alias("login") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <?= csrf() ?>

    <?= component('admin/form/form-input', [
        'name'        => 'email',
        'label'       => $hive->get('admin.email_address'),
        'attrs' => [
            'type'        => 'email',
            'placeholder' => 'email@example.com',
            // 'required'    => true,
        ]
    ]) ?>

    <?= component('admin/form/form-input', [
        'name'        => 'password',
        'label'       => $hive->get('admin.password'),
        'placeholder' => $hive->get('admin.enter_your_password'),
        'attrs' => [
            'type'        => 'password',
            'placeholder' => $hive->get('admin.enter_your_password'),
            // 'required'    => true,
        ]
    ]) ?>

    <div class="flex justify-between gap-2.5">
        <?= component(
            'admin/ui/auth-button',
            ['attrs' => ['type' => 'submit'], 'slot' => $hive->get('admin.log_in')]
        ) ?>
    </div>

</form>

<?php end_slot(); ?>

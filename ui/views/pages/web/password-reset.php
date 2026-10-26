<?php

$hive = \Base::instance(); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => "Восстановление пароля",
    'description' => "Введите пожалуйста номер электронной почты, указанный при регистрации"
]); ?>

<form action="<?= $hive->alias("password_reset_send") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <?= csrf() ?>

    <?= component('web/form/form-input', [
        'name'        => 'email',
        'label'       => 'Электронная почта',
        'attrs' => [
            'type'        => 'email',
            'placeholder' => 'email@example.com',
            'required'    => true,
        ]
    ]) ?>

    <div class="flex justify-between gap-2.5">
        <?= component(
            'web/ui/button',
            [
                'attrs' => ['type' => 'submit'],
                'slot' => 'Отправить',
                'class' => 'px-[2em] mx-auto',
                'size' => 'sm'
            ]
        ) ?>
    </div>

</form>

<?php end_slot(); ?>

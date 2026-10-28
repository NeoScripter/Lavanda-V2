<?php

$hive = \Base::instance(); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => qquila1Восстановление пароляqquila2
,
    'description' => qquila1Введите пожалуйста номер электронной почты, указанный при регистрацииqquila2

]); ?>

<form action="<?= $hive->alias("password_reset_send") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <?= csrf() ?>

    <?= component('web/form/form-input', [
        'name'        => 'email',
        'label'       => qquila1Электронная почтаqquila2
,
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
                'slot' => qquila1Отправитьqquila2
,
                'class' => 'px-[2em] mx-auto',
                'size' => 'sm'
            ]
        ) ?>
    </div>

</form>

<?php end_slot(); ?>

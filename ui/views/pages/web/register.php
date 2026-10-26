<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => "Регистрация",
]); ?>

<?php slot('components/web/layout/info-banner', ['class' => 'mb-2 -mt-4']) ?>
<p class='mb-5'>
    Пройдите экспресс регистрацию за 1 минуту и получите полный доступ ко всем разделам на 24 часа
</p>
<?php end_slot(); ?>

<form cmp-otp-form action="<?= $hive->alias("register_store") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <?= csrf() ?>

    <input type="hidden" name="referrer" value="<?= $hive->HEADERS['Referer'] ?? '@home' ?>">

    <?= component('web/form/form-input', [
        'name'        => 'name',
        'label'       => 'Имя',
        'attrs' => [
            'type'        => 'text',
            'placeholder' => 'Иван Иванов',
            'required'    => true,
            'maxlength' => 200,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'email',
        'label'       => 'Электронная почта',
        'attrs' => [
            'type'        => 'email',
            'placeholder' => 'email@example.com',
            'required'    => true,
            'maxlength' => 200,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'password',
        'label'       => 'Пароль',
        'attrs' => [
            'type'        => 'password',
            'placeholder' => 'Введите пароль',
            'required'    => true,
            'minlength' => 8,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'password_confirmation',
        'label'       => 'Повторите пароль',
        'attrs' => [
            'type'        => 'password',
            'placeholder' => 'Повторите пароль',
            'required'    => true,
            'minlength' => 8,
        ]
    ]) ?>

    <div cmp-otp-input class='hidden'>
        <?= component('web/form/form-input', [
            'name'  => 'otp_code',
            'label' => 'Введите код подтверждения, отправленный вам на электронную почту',
            'error' => $errors['otp_code'] ?? '',
            'attrs' => [
                'type'     => 'text',
                'required' => false,
                'minlength' => 6,
                'maxlength' => 6,
            ],
        ]) ?>
    </div>

    <div class="flex justify-between gap-2.5">
        <?= component(
            'web/ui/button',
            [
                'attrs' => ['type' => 'submit'],
                'slot' => 'Зарегистрироваться',
                'class' => 'px-[2em] mx-auto',
                'size' => 'sm'
            ]
        ) ?>
    </div>

    <div class='space-y-2 text-balance'>
        <?= component('web/form/checkbox', [
            'name'        => 'agreement_accepted',
            'label'       => "Даю согласие на <a href='/legal/user_agreement' class='text-sm underline hover:text-primary transition-colors underline-offset-5'>обработку персональных данных</a>",
            'attrs' => ['required' => true]
        ]) ?>

        <?= component('web/form/checkbox', [
            'name'        => 'policy_accepted',
            'label'       => "Принимаю <a href='/legal/privacy_policy' class='text-sm underline hover:text-primary transition-colors underline-offset-5'>политику конфиденциальности</a>",
            'attrs' => ['required' => true]
        ]) ?>
    </div>
</form>


<?php end_slot(); ?>

<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => qquila1Регистрацияqquila2
,
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
        'label'       => qquila1Имяqquila2
,
        'attrs' => [
            'type'        => 'text',
            'placeholder' => qquila1Иван Ивановqquila2
,
            'required'    => true,
            'maxlength' => 200,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'email',
        'label'       => qquila1Электронная почтаqquila2
,
        'attrs' => [
            'type'        => 'email',
            'placeholder' => 'email@example.com',
            'required'    => true,
            'maxlength' => 200,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'password',
        'label'       => qquila1Парольqquila2
,
        'attrs' => [
            'type'        => 'password',
            'placeholder' => qquila1Введите парольqquila2
,
            'required'    => true,
            'minlength' => 8,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'password_confirmation',
        'label'       => qquila1Повторите парольqquila2
,
        'attrs' => [
            'type'        => 'password',
            'placeholder' => qquila1Повторите парольqquila2
,
            'required'    => true,
            'minlength' => 8,
        ]
    ]) ?>

    <div cmp-otp-input class='hidden'>
        <?= component('web/form/form-input', [
            'name'  => 'otp_code',
            'label' => qquila1Введите код подтверждения, отправленный вам на электронную почтуqquila2
,
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
                'slot' => qquila1Зарегистрироватьсяqquila2
,
                'class' => 'px-[2em] mx-auto',
                'size' => 'sm'
            ]
        ) ?>
    </div>

    <div class='space-y-2 text-balance'>
        <?= component('web/form/checkbox', [
            'name'        => 'agreement_accepted',
            'label'       => "{qquila1Даю согласие наqquila2
} <a href='/legal/user_agreement' class='text-sm underline hover:text-primary transition-colors underline-offset-5'>{qquila1обработку персональных данныхqquila2
}</a>",
            'attrs' => ['required' => true]
        ]) ?>

        <?= component('web/form/checkbox', [
            'name'        => 'policy_accepted',
            'label'       => "{qquila1Принимаюqquila2
} <a href='/legal/privacy_policy' class='text-sm underline hover:text-primary transition-colors underline-offset-5'>{qquila1политику конфиденциальностиqquila2
}</a>",
            'attrs' => ['required' => true]
        ]) ?>
    </div>
</form>


<?php end_slot(); ?>

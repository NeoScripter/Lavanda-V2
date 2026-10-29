<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => $hive->get("web.регистрация"),
]); ?>

<?php slot('components/web/layout/info-banner', ['class' => 'mb-2 -mt-4']) ?>
<p class='mb-5'><?= $hive->get("web.пройдите_экспресс_регистрацию_за_минуту_и_получите_полный_доступ_ко_всем_разделам_на_часа") ?>
</p>
<?php end_slot(); ?>

<form cmp-otp-form action="<?= $hive->alias("register_store") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <?= csrf() ?>

    <input type="hidden" name="referer" value="<?= $hive->HEADERS['Referer'] ?? '@home' ?>">

    <?= component('web/form/form-input', [
        'name'        => 'name',
        'label'       => $hive->get("web.имя"),
        'attrs' => [
            'type'        => 'text',
            'placeholder' => $hive->get("web.иван_иванов"),
            'required'    => true,
            'maxlength' => 200,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'email',
        'label'       => $hive->get("web.электронная_почта"),
        'attrs' => [
            'type'        => 'email',
            'placeholder' => 'email@example.com',
            'required'    => true,
            'maxlength' => 200,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'password',
        'label'       => $hive->get("web.пароль"),
        'attrs' => [
            'type'        => 'password',
            'placeholder' => $hive->get("web.введите_пароль"),
            'required'    => true,
            'minlength' => 8,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'password_confirmation',
        'label'       => $hive->get("web.повторите_пароль"),
        'attrs' => [
            'type'        => 'password',
            'placeholder' => $hive->get("web.повторите_пароль"),
            'required'    => true,
            'minlength' => 8,
        ]
    ]) ?>

    <div cmp-otp-input class='hidden'>
        <?= component('web/form/form-input', [
            'name'  => 'otp_code',
            'label' => $hive->get("web.введите_код_подтверждения_отправленный_вам_на_электронную_почту"),
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
                'slot' => $hive->get("web.зарегистрироваться"),
                'class' => 'px-[2em] mx-auto',
                'size' => 'sm'
            ]
        ) ?>
    </div>

    <div class='space-y-2 text-balance'>
        <?= component('web/form/checkbox', [
            'name'        => 'agreement_accepted',
            'label'       => "{$hive->get("web.даю_согласие_на")} <a href='/legal/user_agreement' class='text-sm underline hover:text-primary transition-colors underline-offset-5'>{$hive->get("web.обработку_персональных_данных")}</a>",
            'attrs' => ['required' => true]
        ]) ?>

        <?= component('web/form/checkbox', [
            'name'        => 'policy_accepted',
            'label'       => "{$hive->get("web.принимаю")} <a href='/legal/privacy_policy' class='text-sm underline hover:text-primary transition-colors underline-offset-5'>{$hive->get("web.политику_конфиденциальности")}</a>",
            'attrs' => ['required' => true]
        ]) ?>
    </div>
</form>


<?php end_slot(); ?>

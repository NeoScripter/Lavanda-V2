<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => "Добро пожаловать!",
    'description' => "Для доступа ко всем разделам ресурса, пожалуйста, войдите."
]); ?>

<form action="<?= $hive->alias("login_store") ?>" method="post" class="max-w-160 flex flex-col gap-6">
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

    <?= component('web/form/form-input', [
        'name'        => 'password',
        'label'       => 'Пароль',
        'attrs' => [
            'type'        => 'password',
            'placeholder' => 'Введите пароль',
            'required'    => true,
        ]
    ]) ?>

    <div class="flex justify-between gap-2.5">
        <?= component(
            'web/ui/button',
            [
                'attrs' => ['type' => 'submit'],
                'slot' => 'Войти',
                'class' => 'px-[2em] mx-auto',
                'size' => 'sm'
            ]
        ) ?>
    </div>

</form>

<?php slot('components/web/layout/info-banner', ['class' => 'mt-5']) ?>
<p class='mb-5'>Впервые на сайте? Пройдите экспресс регистрацию за 1 минуту и получите полный доступ ко всем разделам на 24 часа</p>

<?= component(
    'web/ui/button',
    [
        'slot' => 'Регистрация',
        'variant' => 'outline',
        'href' => $hive->alias('register'),
        'class' => 'px-[2em] mx-auto w-fit',
        'size' => 'sm'
    ]
) ?>
<?php end_slot(); ?>

<?php end_slot(); ?>

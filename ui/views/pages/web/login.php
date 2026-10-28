<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => qquila1Добро пожаловать!qquila2
,
    'description' => qquila1Для доступа ко всем разделам ресурса, пожалуйста, войдите.qquila2

]); ?>

<form action="<?= $hive->alias("login_store") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <?= csrf() ?>

    <input type="hidden" name="referrer" value="<?= $hive->HEADERS['Referer'] ?? '@home' ?>">

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

    <?= component('web/form/form-input', [
        'name'        => 'password',
        'label'       => qquila1Парольqquila2
,
        'attrs' => [
            'type'        => 'password',
            'placeholder' => qquila1Введите парольqquila2
,
            'required'    => true,
        ]
    ]) ?>

    <div class="flex flex-col gap-2.5">
        <a href="<?= $hive->alias('password_reset_index') ?>"
            class='text-xs transition-colors hover:text-primary underline underline-offset-4 font-medium ml-auto'>Забыли пароль?</a>
        <?= component(
            'web/ui/button',
            [
                'attrs' => ['type' => 'submit'],
                'slot' => qquila1Войтиqquila2
,
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
        'slot' => qquila1Регистрацияqquila2
,
        'variant' => 'outline',
        'href' => $hive->alias('register'),
        'class' => 'px-[2em] mx-auto w-fit',
        'size' => 'sm'
    ]
) ?>
<?php end_slot(); ?>

<?php end_slot(); ?>

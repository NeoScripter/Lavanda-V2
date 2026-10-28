<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => $hive->get("web.добро_пожаловать"),
    'description' => $hive->get("web.для_доступа_ко_всем_разделам_ресурса_пожалуйста_войдите")

]); ?>

<form action="<?= $hive->alias("login_store") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <?= csrf() ?>

    <input type="hidden" name="referrer" value="<?= $hive->HEADERS['Referer'] ?? '@home' ?>">

    <?= component('web/form/form-input', [
        'name'        => 'email',
        'label'       => $hive->get("web.электронная_почта"),
        'attrs' => [
            'type'        => 'email',
            'placeholder' => 'email@example.com',
            'required'    => true,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'password',
        'label'       => $hive->get("web.пароль"),
        'attrs' => [
            'type'        => 'password',
            'placeholder' => $hive->get("web.введите_пароль"),
            'required'    => true,
        ]
    ]) ?>

    <div class="flex flex-col gap-2.5">
        <a href="<?= $hive->alias('password_reset_index') ?>"
            class='text-xs transition-colors hover:text-primary underline underline-offset-4 font-medium ml-auto'>
            <?= $hive->get('web.забыли_пароль_') ?>
        </a>
        <?= component(
            'web/ui/button',
            [
                'attrs' => ['type' => 'submit'],
                'slot' => $hive->get("web.войти"),
                'class' => 'px-[2em] mx-auto',
                'size' => 'sm'
            ]
        ) ?>
    </div>

</form>

<?php slot('components/web/layout/info-banner', ['class' => 'mt-5']) ?>
<p class='mb-5'>
    <?= $hive->get('web._впервые_на_сайте_пройдите_экспресс_регистрацию_за_минуту_и_получите_полный_доступ_ко_всем_разделам_на_часа_') ?>
</p>

<?= component(
    'web/ui/button',
    [
        'slot' => $hive->get("web.регистрация"),
        'variant' => 'outline',
        'href' => $hive->alias('register'),
        'class' => 'px-[2em] mx-auto w-fit',
        'size' => 'sm'
    ]
) ?>
<?php end_slot(); ?>

<?php end_slot(); ?>

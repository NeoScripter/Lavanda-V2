<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => $hive->get("web.добро_пожаловать"),
    'description' => $hive->get("web.для_доступа_ко_всем_разделам_ресурса_пожалуйста_войдите")

]); ?>

<form action="<?= $hive->alias("login_store") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <?= csrf() ?>

    <input type="hidden" name="referer" value="<?= $hive->HEADERS['Referer'] ?? '@home' ?>">

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
            <?= $hive->get('web.забыли_пароль') ?>
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
<div class='mb-5 space-y-[0.5em] *:text-sm!'>
    <p><?= $hive->get('web.в_пространстве_лаванда_должно_быть_спокойно_во_всём') ?></p>
    <p><?= $hive->get('web.мы_создаём_личный_кабинет_чтобы_ты_мог_в_любое_время_вернуться_к_своему_доступу_и_пользоваться_пространством_лаванда') ?></p>
    <p><?= $hive->get('web.уважаем_твои_границы_на_почту_приходят_только_ответы_и_уведомления_по_запросу_никаких_рекламных') ?></p>
    <p><?= $hive->get('web.за_прозрачность_и_спокойствие_никаких_автоматических_подписок_скрытых_платежей_и_автосписаний') ?></p>
    <p><?= $hive->get('web.заботимся_о_безопасности_оплата_проходит_через_защищённый_платёжный_шлюз_мы_не_получаем_доступа_к_твоим_платёжным_данным') ?></p>
</div>

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

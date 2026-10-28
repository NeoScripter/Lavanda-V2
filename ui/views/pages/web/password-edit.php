<?php 

$hive = \Base::instance();

extract(component_props(
    required: ['signature'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => $hive->get("web.изменение_пароля")
,
    'description' => $hive->get("web.введите_новый_пароль_от_аккаунта")

]); ?>

<form action="<?= $hive->alias("password_reset_update") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <input type="hidden" name="_method" value="patch">
    <input type="hidden" name="signature" value="<?= $signature ?>">
    <?= csrf() ?>

    <?= component('web/form/form-input', [
        'name'        => 'password',
        'label'       => $hive->get("web.пароль")
,
        'attrs' => [
            'type'        => 'password',
            'placeholder' => $hive->get("web.введите_пароль")
,
            'required'    => true,
            'minlength' => 8,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'password_confirmation',
        'label'       => $hive->get("web.повторите_пароль")
,
        'attrs' => [
            'type'        => 'password',
            'placeholder' => $hive->get("web.повторите_пароль")
,
            'required'    => true,
            'minlength' => 8,
        ]
    ]) ?>

    <div class="flex justify-between gap-2.5">
        <?= component(
            'web/ui/button',
            [
                'attrs' => ['type' => 'submit'],
                'slot' => $hive->get("web.отправить")
,
                'class' => 'px-[2em] mx-auto',
                'size' => 'sm'
            ]
        ) ?>
    </div>

</form>

<?php end_slot(); ?>

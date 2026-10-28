<?php 

$hive = \Base::instance();

extract(component_props(
    required: ['signature'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/auth-layout', [
    'title' => qquila1Изменение пароляqquila2
,
    'description' => qquila1Введите новый пароль от аккаунтаqquila2

]); ?>

<form action="<?= $hive->alias("password_reset_update") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <input type="hidden" name="_method" value="patch">
    <input type="hidden" name="signature" value="<?= $signature ?>">
    <?= csrf() ?>

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

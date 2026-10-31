<?php

$hive = \Base::instance();

extract(component_props(
    required: ['user'],
    optional: [],
    props: get_defined_vars(),
));

slot('layouts/web/auth-layout', [
    'title' => $hive->get("web.персональный_разбор"),
]); ?>

<?php slot('components/web/layout/info-banner', ['class' => 'mb-2 -mt-4']) ?>
<p><?= $hive->get('web.консультация_это_пространство_для_размышления_а_не_замена_помощи_психолога_или_врача') ?></p>
<p class='my-3'>
    <?= $hive->get('web.спасибо_за_доверие') ?>
</p>
<p class='mb-5'>
    <?= $hive->get('web.lavanda_пространство_где_можно_исследовать_себя_без_давления_и_получить_бережный_взгляд_со_стороны') ?>
</p>

<?php end_slot(); ?>

<form action="<?= $hive->alias("consultation") ?>" method="post" class="max-w-160 flex flex-col gap-6">
    <?= csrf() ?>

    <?= component('web/form/form-input', [
        'name'        => 'name',
        'label'       => $hive->get("web.как_к_тебе_обращаться"),
        'attrs' => [
            'type'        => 'text',
            'placeholder' => $hive->get("web.твоё_имя_или_любое_удобное_обращение"),
            'required'    => true,
            'value' => $user['name'],
            'maxlength' => 200,
        ]
    ]) ?>

    <?= component('web/form/form-input', [
        'name'        => 'email',
        'label'       => $hive->get("web.куда_тебе_ответить"),
        'attrs' => [
            'type'        => 'email',
            'placeholder' => 'email_где_тебе_удобно_получить_ответ',
            'required'    => true,
            'value' => $user['email'],
            'maxlength' => 200,
        ]
    ]) ?>

    <?= component('web/form/form-textarea', [
        'name'        => 'message',
        'label'       => $hive->get("web.с_чем_ты_хочешь_разобраться"),
        'attrs' => [
            'placeholder' => $hive->get("web.опиши_свою_ситуацию_или_задай_вопрос_своими_словами"),
            'required'    => true,
            'minlength' => 8,
        ]
    ]) ?>
    <?= component('web/form/form-textarea', [
        'name'        => 'emphasis',
        'label'       => $hive->get("web.на_что_хотелось_бы_посмотреть_в_первую_очередь"),
        'attrs' => [
            'placeholder' => $hive->get("web.например_на_свои_чувства_отношения_возможные_пути_решения_или_на_то_что_пока_скрыто_от_твоего_внимания"),
            'minlength' => 8,
        ]
    ]) ?>
    <?= component('web/form/form-textarea', [
        'name'        => 'other',
        'label'       => $hive->get("web.есть_ли_что_то_ещё_что_мне_важно_знать"),
        'attrs' => [
            'placeholder' => $hive->get("web.любые_обстоятельства_детали_или_мысли_которые_помогут_лучше_понять_твою_ситуацию"),
            'minlength' => 8,
        ]
    ]) ?>

    <div class="flex justify-between gap-2.5">
        <?= component(
            'web/ui/button',
            [
                'attrs' => ['type' => 'submit'],
                'slot' => $hive->get("web.отправить"),
                'class' => 'px-[2em] mx-auto',
                'size' => 'sm'
            ]
        ) ?>
    </div>

    <div class='space-y-2 text-balance'>
        <?= component('web/form/checkbox', [
            'name'        => 'policy_accepted',
            'label'       => "{$hive->get("web.я_согласна_согласен_на_обработку")} <a href='/legal/privacy_policy' class='text-sm underline hover:text-primary transition-colors underline-offset-5'>{$hive->get("web.моих_данных")}</a> {$hive->get("web.для_ответа_на_запрос")}",
            'attrs' => ['required' => true]
        ]) ?>
    </div>
</form>


<?php end_slot(); ?>

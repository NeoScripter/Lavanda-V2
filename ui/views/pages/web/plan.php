<?php

use Enums\LegalSlug;

extract(component_props(
    required: ['item'],
    optional: ['class' => ''],
    props: get_defined_vars()
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.оформление_тарифа"),
    'class' => 'bg-white relative isolate',
]); ?>

<?php $hive = \Base::instance(); ?>

<?php ob_start(); ?>

<form action="<?= $hive->alias('pay') ?>" method="post" class='w-fit mx-auto'>
    <?= csrf() ?>
    <input type="hidden" name="slug" value="<?= $item['slug'] ?>">

    <?= component('web/ui/button', [
        'slot' => $hive->get("web.оплатить"),
        'class' => 'min-w-50',
        'size' => 'sm',
    ]); ?>

</form>
<a href="<?= $hive->alias('plans') ?>" class='text-center text-sm mt-2 hover:underline underline-offset-4'><?= $hive->get("web.посмотреть_другие_форматы_") ?>
</a>
<?php $button = ob_get_clean(); ?>

<section class='pt-(--pt-lg)'>

    <h1><?= $hive->get("web.оформление_тарифа_") ?>
    </h1>

    <div class='gap-y-45 grid place-content-center mt-38 sm:mt-45 md:mt-50 2xl:mx-0'>
        <?= component('web/ui/plan-card', [
            'item' => $item,
            'as' => 'article',
            'button' => $button
        ]) ?>
    </div>

    <article class='bg-white w-full max-w-120 shadow-accent lg:max-w-220 mx-auto xs:rounded-xl sm:rounded-primary px-6 py-9 sm:py-11 sm:px-9 lg:px-12 xl:px-15 mt-(--spacing-y)'>

        <ul class='list-inside list-disc space-y-[0.5em]'>
            <?= $hive->get("web.оформляя_подписку_на_сайте_") ?>
            <span class='text-primary'>Lavanda<sup>Kim</sup></span>,
            <?= $hive->get("web.вы_подтверждаете_что") ?>

            <li class='mt-[0.5em]'><?= $hive->get("web.приобретаете_доступ_к_цифровому_контенту_развлекательного_и_информационного_характера_") ?>
            </li>
            <li><?= $hive->get("web.понимаете_что_материалы_сайта_не_являются_психологической_медицинской_терапевтической_или_иной_профессиональной_услугой_") ?>
            </li>
            <li>
                <?= $hive->get("web.соглашаетесь_с_") ?>

                <a class='underline underline-offset-4 text-primary' href="<?= $hive->alias('legal', ['slug' => LegalSlug::CONSENT->value]) ?>">
                    <?= $hive->get("web.пользовательским_соглашением_") ?>

                </a> и <a class='underline underline-offset-4 text-primary' href="<?= $hive->alias('legal', ['slug' => LegalSlug::POLICY->value]) ?>"><?= $hive->get("web.политикой_конфиденциальности_сайта_") ?>
                </a>;
            </li>
            <li><?= $hive->get("web._понимаете_что_оплата_разовая_доступ_действует_в_рамках_выбранного_формата_или_до_окончания_оплаченного_периода_и_не_продлевается_") ?>
            </li>
            <li><?= $hive->get("web._соглашаетесь_что_доступ_к_цифровому_контенту_предоставляется_сразу_после_оплаты_и_после_этого_возврат_платежа_возможен_только_в_случаях_предусмотренных_условиями_сервиса_") ?>
            </li>
            <li class='mb-[0.5em]'>qquila1 Нажимая «Оплатить», вы подтверждаете корректность данных и своё согласие на списание стоимости выбранного формата. qquila2
            </li>
            <?= $hive->get("web.нажимая_оплатить_вы_подтверждаете_корректность_данных_и_своё_согласие_на_списание_стоимости_подписки_") ?>

        </ul>
    </article>

</section>

<span class='absolute inset-0 bg-cover bg-no-repeat bg-center -z-1 size-full' style="background-image: url(/assets/images/shared/backgrounds/flowers/flowers-mb.webp);"></span>

<?php end_slot(); ?>

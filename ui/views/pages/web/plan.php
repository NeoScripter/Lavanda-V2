<?php

use Enums\LegalSlug;

extract(component_props(
    required: ['item'],
    optional: ['class' => ''],
    props: get_defined_vars()
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => qquila1Оформление тарифаqquila2
,
    'class' => 'bg-white relative isolate',
]); ?>

<?php $hive = \Base::instance(); ?>

<?php ob_start(); ?>

<form action="<?= $hive->alias('pay') ?>" method="post" class='w-fit mx-auto'>
    <?= csrf() ?>
    <input type="hidden" name="slug" value="<?= $item['slug'] ?>">

    <?= component('web/ui/button', [
        'slot' => qquila1Оплатитьqquila2
,
        'class' => 'min-w-50',
        'size' => 'sm',
    ]); ?>

</form>
<a href="<?= $hive->alias('plans') ?>" class='text-center text-sm mt-2 hover:underline underline-offset-4'>Посмотреть другие форматы</a>
<?php $button = ob_get_clean(); ?>

<section class='pt-(--pt-lg)'>

    <h1>Оформление тарифа</h1>

    <div class='gap-y-45 grid place-content-center mt-38 sm:mt-45 md:mt-50 2xl:mx-0'>
        <?= component('web/ui/plan-card', [
            'item' => $item,
            'as' => 'article',
            'button' => $button
        ]) ?>
    </div>

    <article class='bg-white w-full max-w-120 shadow-accent lg:max-w-220 mx-auto xs:rounded-xl sm:rounded-primary px-6 py-9 sm:py-11 sm:px-9 lg:px-12 xl:px-15 mt-(--spacing-y)'>

        <ul class='list-inside list-disc space-y-[0.5em]'>
            Оформляя подписку на сайте <span class='text-primary'>Lavanda<sup>Kim</sup></span>, вы подтверждаете, что:

            <li class='mt-[0.5em]'>приобретаете доступ к цифровому контенту развлекательного и информационного характера;</li>
            <li>понимаете, что материалы сайта не являются психологической, медицинской, терапевтической или иной профессиональной услугой;</li>
            <li>соглашаетесь с <a class='underline underline-offset-4 text-primary' href="<?= $hive->alias('legal', ['slug' => LegalSlug::CONSENT->value]) ?>">Пользовательским соглашением</a> и <a class='underline underline-offset-4 text-primary' href="<?= $hive->alias('legal', ['slug' => LegalSlug::POLICY->value]) ?>">Политикой конфиденциальности сайта</a>;</li>
            <li> понимаете, что оплата разовая: доступ действует в рамках выбранного формата или до окончания оплаченного периода и не продлевается </li>
            <li> соглашаетесь, что доступ к цифровому контенту предоставляется сразу после оплаты, и после этого возврат платежа возможен только в случаях, предусмотренных условиями сервиса. </li>
            <li class='mb-[0.5em]'> Нажимая «Оплатить», вы подтверждаете корректность данных и своё согласие на списание стоимости выбранного формата.
            </li>
            Нажимая «Оплатить», вы подтверждаете корректность данных и своё согласие на списание стоимости подписки.
        </ul>
    </article>

</section>

<span class='absolute inset-0 bg-cover bg-no-repeat bg-center -z-1 size-full' style="background-image: url(/assets/images/shared/backgrounds/flowers/flowers-mb.webp);"></span>

<?php end_slot(); ?>

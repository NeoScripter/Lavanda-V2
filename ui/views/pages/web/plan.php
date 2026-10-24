<?php extract(component_props(
    required: ['item'],
    optional: ['class' => ''],
    props: get_defined_vars()
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Оформление подписки',
    'class' => 'bg-white relative isolate',
]); ?>

<?php $hive = \Base::instance(); ?>

<?php ob_start(); ?>

<?= component('web/ui/button', [
    'slot' => 'Оплатить',
    'class' => '',
]); ?>

<?php $button = ob_get_clean(); ?>

<section class='pt-(--pt-lg)'>

    <h1>Оформление подписки</h1>

    <div class='gap-y-45 grid place-content-center mt-38 sm:mt-45 md:mt-50 2xl:mx-0'>
        <?= component('web/ui/plan-card', ['item' => $item, 'as' => 'article', 'button_label' => 'Оплатить', 'url' => $hive->alias('pay')]) ?>
    </div>

    <article class='bg-white w-full max-w-120 shadow-accent lg:max-w-220 mx-auto xs:rounded-xl sm:rounded-primary px-6 py-9 sm:py-11 sm:px-9 lg:px-12 xl:px-15 mt-(--spacing-y)'>

        <ul class='list-inside list-disc space-y-[0.5em]'>
            Оформляя подписку на сайте <span class='text-primary'>Lavanda<sup>Kim</sup></span>, вы подтверждаете, что:

            <li class='mt-[0.5em]'>приобретаете доступ к цифровому контенту развлекательного и информационного характера;</li>
            <li>понимаете, что материалы сайта не являются психологической, медицинской, терапевтической или иной профессиональной услугой;</li>
            <li>соглашаетесь с Пользовательским соглашением и Политикой конфиденциальности сайта;</li>
            <li>подписка является автоматически продлевающейся, если иное не указано в тарифе;</li>
            <li>вы можете отменить подписку в любой момент в личном кабинете или обратившись по адресу: info@lavanda.kim — доступ будет сохраняться до окончания оплаченного периода;</li>
            <li class='mb-[0.5em]'>после активации подписки возврат платежа возможен только в случаях, предусмотренных условиями сервиса.</li>

            Нажимая «Оплатить», вы подтверждаете корректность данных и своё согласие на списание стоимости подписки.
        </ul>
    </article>

</section>

<span class='absolute inset-0 bg-cover bg-no-repeat bg-center -z-1 size-full' style="background-image: url(/assets/images/shared/backgrounds/flowers/flowers-mb.webp);"></span>

<?php end_slot(); ?>

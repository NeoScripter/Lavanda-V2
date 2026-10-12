<?php

extract(component_props(
    required: ['affirmations', 'topic'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Настрой',
]); ?>

<?php ob_start(); ?>

<h1>Настрой на день: <?= $topic ?></h1>

<div class='space-y-[1em] text-center text-balance max-w-200 mx-auto'>
    <p>Карточки на каждый день, чтобы вернуть опору, спокойствие и веру в себя. Подходят, когда нужно настроиться на лучшее и укрепить внутренний ресурс.</p>
</div>

<div class='mt-10 mx-auto flex items-center justify-center flex-col sm:flex-row gap-y-4 gap-x-6'>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Начать',
        'class' => 'min-w-40',
        'attrs' => ['cmp-aff-btn' => true]
    ]) ?>

    <?= component('web/ui/button', [
        'variant' => 'outline',
        'slot' => 'Сменить тему',
        'class' => '',
        'href' => $hive->alias('affirmation_topics')
    ]) ?>
</div>
<?php $slot1 = ob_get_clean(); ?>

<?php ob_start(); ?>

<div cmp-aff-wrapper
    class='flex flex-col gap-4 sm:gap-6 py-6 justify-center items-center overflow-clip'>
    <?php slot('components/web/layout/planet-spinner', [
        'count' => count($affirmations),
        'ratio' => 12,
        'gap' => 4,
    ]); ?>
    <?php foreach ($affirmations as $idx => $affirmation) : ?>
        <li data-quote="<?= $affirmation->quote ?>"
            class='bg-white shadow-accent flex items-center justify-center rounded-md aspect-square'
            style="--index: <?= $idx ?>; --tilt: 1%;">
            <?= component('shared/ui/image', [
                'sizes'    => 'mb',
                'path'     => '/assets/images/pages/affirmations/pattern',
                'alt'     => 'dark image of a heart',
                'lazy' => false,
                'prt_class' => 'size-2/3 bg-contain! isolate transition-transform',
                'img_class' => 'object-contain!',
            ]) ?>
        </li>
    <?php endforeach; ?>

    <?php end_slot(); ?>

    <p cmp-aff-quote
        class="text-white px-4 text-center empty:hidden text-balance font-medium text-lg md:text-xl xl:text-2xl">
    </p>
</div>

<?php $slot2 = ob_get_clean(); ?>

<?= component('web/layout/split', [
    'slot1' => $slot1,
    'slot2' => $slot2,
    'class' => '[&>*:last-child]:justify-center! [&>*:last-child]:px-0!'
]); ?>

<?php end_slot(); ?>

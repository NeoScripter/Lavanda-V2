<?php slot('layouts/web/app-layout', [
    'title' => 'Тибетское гадание МО',
]); ?>

<?php ob_start(); ?>
Тибетское гадание МО
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>МО — маленький ритуал, которому уже много веков. Два кубика. Шесть священных слогов. Тридцать шесть возможных комбинаций.
    Всё остальное начинается с твоего вопроса.</p>
<p>В тибетской традиции к МО обращались не только за советом. Говорят, его использовали и врачи тибетской медицины — чтобы лучше понять причину болезни, выбрать направление лечения или благоприятное время для его начала.</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => 'Перейти к игре',
    'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
]) ?>
<?php $slot = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/dices/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'slot', 'image')); ?>
</section>

<?php ob_start(); ?>
<div>
    <div cmp-visible-at-start class='text-balance text-center md:mx-auto max-w-200 -mx-4'>
        <h2 class='text-lg normal-case md:text-xl lg:text-2xl text-white'>Задай вопрос. Брось кубики. Узнай свою комбинацию МО.</h2>
        <p>
            В выпадающем окне ниже выбери тему своего вопроса, чтобы получить наиболее точное трактование
        </p>
    </div>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Получить ответ',
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-at-start' => true
        ],
        'class' => 'mx-auto'
    ]) ?>

    <div class='flex items-center justify-center flex-col xs:flex-row'>
        <?= component('web/ui/dice') ?>
        <?= component('web/ui/dice') ?>
    </div>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Попробовать снова',
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>
</div>
<?php $slot1 = ob_get_clean(); ?>

<?php $dices = require(APP_DIR . '/ui/data/models/dices.php'); ?>

<?php ob_start(); ?>
<div>
    <h3 class='text-balance text-center md:mx-auto max-w-200 -mx-4 mb-[2em]! text-xl uppercase md:text-2xl lg:text-3xl'>Как читать грани</h3>
    <ul class='max-w-275 mx-auto gap-y-8 gap-x-10.5 sm:gap-y-10.5 justify-items-center justify-center grid grid-cols-[repeat(auto-fit,min(100%,31rem))]'>
        <?php foreach ($dices as $dice) : ?>

            <li class='border border-primary rounded-xl p-4.5 sm:p-6.5 w-full flex flex-col max-w-80 xs:max-w-full xs:flex-row items-center gap-4.5 sm:gap-6.5'>
                <?= component('shared/ui/image', [
                    'path' => $dice['image'],
                    'alt' => $dice['meaning'],
                    'sizes' => 'mb',
                    'prt_class' => 'aspect-square bg-contain! size-21.5 sm:size-35 shrink-0',
                    'img_class' => 'size-full object-contain!',
                ]) ?>

                <div>
                    <div class='flex items-center gap-2 sm:gap-3 mb-2 sm:mb-3'>
                        <h4 class='uppercase mb-0! text-2xl sm:text-3xl font-bold'><?= $dice['name'] ?></h4>
                        <small class='text-primary text-sm sm:text-base'><?= $dice['meaning'] ?></small>
                    </div>
                    <p class='md:text-lg xl:text-lg'><?= $dice['description'] ?></p>
                </div>
            </li>

        <?php endforeach; ?>
    </ul>

</div>
<?php $interpretation = ob_get_clean(); ?>

<?= component('web/layout/game-stage', [
    'slots' => [$slot1],
    'interpretation' => $interpretation,
    // 'class' => 'hidden'
]); ?>

<?php end_slot(); ?>

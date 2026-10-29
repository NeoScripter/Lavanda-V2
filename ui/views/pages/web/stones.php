<?php

use Enums\GameType;

extract(component_props(
    required: ['stones'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();
$winner = empty($stones) ? null : $stones[array_rand($stones)]; ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.магические_камни"),
]); ?>

<?php ob_start(); ?>
<?= $hive->get("web.камней_в_одном_мешочке") ?>

<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p><strong> <?= $hive->get('web.какой_сегодня_окажется_рядом') ?> </strong></p>
<p class='mb-0'><?= $hive->get("web.перед_вами_камней_один_из_них_окажется_рядом_именно_сейчас_у_каждого_минерала_свой_характер_своя_история_и_свой_способ_быть_опорой") ?> </p>  
<p><?= $hive->get("web.выберите_камень_и_узнайте_с_чем_он_может_сопровождать_вас") ?>
</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => $hive->get("web.перейти_к_игре"),
    'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
]) ?>
<?php $slot = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/stones/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image', 'slot')); ?>
</section>

<section class='[&:has(+_[cmp-game-stage].hidden)]:hidden'>
    <p class='text-center text-balance max-w-200 mx-auto'><?= $hive->get("web.каждое_значение_это_подсказка_предостережение_или_напутствие_на_ближайшее_будущее_узнайте_что_вам_шепчет_камень_возможно_ответ_уже_лежит_на_ладони") ?>
    </p>
</section>


<?php ob_start(); ?>
<div class="isolate">
    <?php if (! empty($winner)) : ?>

        <article cmp-game="<?= GameType::STONE->value ?>"
            cmp-random-stone-game
            data-id="<?= $winner['id'] ?>"
            data-prev-image="<?= $winner['image_src'] ?>"
            data-prev-alt="<?= $winner['image_alt'] ?>">
            <div class='relative mx-auto max-w-160 pt-10 xs:pt-20 w-full grid'>
                <div cmp-initial-sack class='col-start-1 col-end-1 row-start-1 row-end-1 transition-opacity duration-500 ease-in-out'>
                    <?= component('shared/ui/image', [
                        'sizes'    => 'mb|tb|dk',
                        'alt' => 'sack of stones',
                        'lazy' => false,
                        'path'     => '/assets/images/pages/stones/sack',
                        'prt_class' => 'bg-contain! aspect-square',
                        'img_class' => 'size-full object-contain',
                    ]) ?>
                </div>
                <div cmp-closed-sack class='mx-auto col-start-1 col-end-1 row-start-1 row-end-1 opacity-0 aspect-square w-full max-w-200 transition-opacity duration-750 ease-in-out'>
                    <?= component('shared/ui/image', [
                        'sizes'    => 'mb|tb|dk',
                        'alt' => 'closed sack',
                        'lazy' => false,
                        'path'     => '/assets/images/pages/stones/closed-sack',
                        'prt_class' => 'bg-contain! aspect-square',
                        'img_class' => 'size-full object-contain',
                    ]) ?>
                </div>
                <div cmp-open-sack class='mx-auto col-start-1 col-end-1 row-start-1 row-end-1 w-full relative max-w-200 hidden transition-opacity duration-500 ease-in-out'>
                    <?= component('shared/ui/image', [
                        'sizes'    => 'mb|tb|dk',
                        'alt' => 'open sack',
                        'lazy' => false,
                        'path'     => '/assets/images/pages/stones/open-sack',
                        'prt_class' => 'bg-contain! max-h-400 transition-[max-height,opacity] w-full [&.opacity-0]:max-h-50! aspect-square duration-500 ease-in-out',
                        'img_class' => 'size-full object-contain',
                    ]) ?>
                    <div cmp-selected-stone class='starting:opacity-0 w-2/5 aspect-square appearing inset-x-0 top-0 select-none mx-auto duration-500 ease-in-out transition-[opacity,transform]'>
                        <?= component('shared/ui/image', [
                            'sizes'    => 'mb|tb',
                            'alt' => 'cloth',
                            'lazy' => false,
                            'path'     => $winner['image_src'],
                            'prt_class' => 'size-full bg-contain!',
                            'img_class' => 'size-full object-contain',
                        ]) ?>
                    </div>

                </div>
            </div>
        </article>

    <?php endif; ?>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.получить_ответ"),
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-at-start' => true
        ],
        'class' => 'mx-auto'
    ]) ?>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.попробовать_снова"),
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>
    <?= component('web/ui/button', [
        'variant' => 'accent',
        'slot' => $hive->get("web.следующий_раздел"),
        'href' => next_game_route(),
        'class' => 'mx-auto -mt-2 lg:-mt-5 w-fit hidden',
        'attrs' => [
            'cmp-visible-at-end' => true
        ],
    ]) ?>
</div>
<?php $slot1 = ob_get_clean(); ?>

<?php ob_start(); ?>
<div class='relative group min-h-100 md:min-h-150 isolate'>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.получить_ответ"),
        'attrs' => [
            'cmp-show-cloth-btn' => true,
            'cmp-visible-at-start' => true
        ],
        'class' => 'z-20 left-1/2 top-1/2 -translate-1/2 absolute!'
    ]) ?>

    <?php if (! empty($stones)) : ?>
        <ul class="grid grid-rows-3 grid-cols-3 [&:has(+.hidden)]:h-200 place-content-center place-items-center md:h-auto md:aspect-square max-w-160 mx-auto"
            cmp-stone-grid
            cmp-rune-grid
            cmp-visible-at-start
            cmp-visible-during
            cmp-game="<?= GameType::STONE->value ?>">
            <?php foreach ($stones as $idx => $stone) : ?>
                <?= component('web/ui/stone', [
                    'stone' => $stone,
                    'idx' => $idx,
                    'class' => 'w-20 md:w-22 lg:w-25 group-has-[[cmp-stone-cloth]:not(.hidden)]:transform-none!',
                ]) ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (! empty($winner)) : ?>
        <div cmp-visible-during
            cmp-visible-at-end
            cmp-stone-cloth
            data-id="<?= $winner['id'] ?>"
            data-prev-image="<?= $winner['image_src'] ?>"
            data-prev-alt="<?= $winner['image_alt'] ?>"
            class='absolute select-none starting:opacity-0 transition-opacity duration-300 ease-in-out hidden inset-0 z-20 left-1/2 top-1/2 -translate-1/2 aspect-square w-[min(100vw,150%)] xs:w-[min(90vw,80%)] lg:w-[60%] xl:w-1/2'>
            <?= component('shared/ui/image', [
                'sizes'    => 'mb|tb|dk',
                'alt' => 'cloth',
                'path'     => '/assets/images/pages/stones/cloth',
                'prt_class' => 'w-full bg-contain!',
                'lazy' => false,
                'img_class' => 'size-full object-contain',
            ]) ?>
            <div class='absolute left-1/2 top-0 [&:has(+*+:not(.hidden))]:hidden -translate-x-1/2 backdrop-blur-sm border border-white rounded-lg p-4 w-[min(100vw,25rem)] md:left-0 md:translate-x-0'>
                <span
                    class='absolute left-0 top-0 hidden sm:block -translate-1/2 size-7 backdrop-blur-2xl bg-primary-pale/50 *:size-full rounded-full text-white'>
                    <?= svg('info-circle') ?>
                </span><?= $hive->get("web.нажмите_в_любую_область_платка_чтобы_вытянуть_камень") ?>
            </div>
            <button cmp-pickable-item class='absolute inset-0 size-2/3 cursor-pointer m-auto [&:has(+:not(.hidden))]:hidden'></button>
            <div cmp-winner-stone class='starting:opacity-0 duration-300 ease-in-out transition-opacity hidden '>
                <?= component('shared/ui/image', [
                    'sizes'    => 'mb|tb',
                    'alt' => 'cloth',
                    'lazy' => false,
                    'path'     => $winner['image_src'],
                    'prt_class' => 'size-2/5 absolute! inset-0 m-auto bg-contain!',
                    'img_class' => 'size-full object-contain',
                ]) ?>
            </div>
        </div>

    <?php endif; ?>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.попробовать_снова"),
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden relative z-40'
    ]) ?>
    <?= component('web/ui/button', [
        'variant' => 'accent',
        'slot' => $hive->get("web.следующий_раздел"),
        'href' => next_game_route(),
        'class' => 'mx-auto -mt-2 lg:-mt-5 w-fit hidden relative z-40',
        'attrs' => [
            'cmp-visible-at-end' => true
        ],
    ]) ?>
</div>
<?php $slot2 = ob_get_clean(); ?>

<?php $labels = [
    $hive->get("web.выбор_лаванды"),
    $hive->get("web.выбор_гостя")
]; ?>

<?= component('web/layout/game-stage', [
    'labels' => $labels,
    'slots' => [$slot1, $slot2],
    'class' => 'stones hidden'
]); ?>

<?php end_slot(); ?>

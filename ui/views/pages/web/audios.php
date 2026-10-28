<?php

extract(component_props(
    required: ['audios'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.послание_поддержки")
,
]); ?>

<?php ob_start(); ?>

<h1>Послание поддержки от автора</h1>

<div class='space-y-[1em] text-center text-balance max-w-200 mx-auto'>
    <p>Здесь вы можете услышать короткие (или не очень) голосовые записи от автора Lavanda Kim. Каждая запись звучит как доверительный разговор. Это особенный раздел, ведь в каждое сообщение в разное время автор вложила кусочек своей души и тепла, откровение или личный опыт, а некоторые истории вы услышите первыми.</p>

    <p>Состав аудиозаписей постоянно обновляется. Некоторые размещаются на ограниченное время. Не пропустите именно Ваше послание!
    </p>
</div>

<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => $hive->get("web.начать")
,
    'class' => 'w-fit mt-10 mx-auto',
    'attrs' => ['cmp-audio-btn' => true, 'data-repeat-label' => $hive->get("web.повторить")
]
]) ?>
<?php $slot1 = ob_get_clean(); ?>

<?php ob_start(); ?>

<div cmp-audio-wrapper class='flex h-full flex-col justify-center gap-6'>
    <h2 cmp-audio-description class='text-white empty:hidden text-xl md:text-2xl lg:text-3xl'></h2>

    <?php slot('components/web/layout/planet-spinner', [
        'count' => count($audios),
        'ratio' => 12,
        'gap' => 1.8,
        'class' => 'mb-10'
    ]); ?>
    <?php foreach ($audios as $idx => $audio) : ?>
        <li data-file="<?= $audio['file'] ?>"
            data-description="<?= $audio['description'] ?>"
            class='bg-white shadow-accent flex items-center justify-center rounded-md aspect-square'
            style="--index: <?= $idx ?>">
            <?= component('shared/ui/image', [
                'sizes'    => 'mb',
                'path'     => '/assets/images/pages/audios/heart',
                'alt'     => 'dark image of a heart',
                'lazy' => false,
                'prt_class' => 'size-2/3 bg-contain! isolate transition-transform',
                'img_class' => 'object-contain!',
            ]) ?>
        </li>
    <?php endforeach; ?>

    <?php end_slot(); ?>

    <?php if (! empty($audios)) : ?>
        <?= component('web/ui/audio-player', [
            'figcaption' => $audios[0]['description'],
            'src' => $audios[0]['file'],
            'class' => 'hidden',
        ]) ?>
    <?php endif; ?>
</div>
<?php $slot2 = ob_get_clean(); ?>

<?= component('web/layout/split', [
    'slot1' => $slot1,
    'slot2' => $slot2,
]); ?>

<?php end_slot(); ?>

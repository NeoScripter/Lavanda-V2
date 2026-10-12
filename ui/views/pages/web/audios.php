<?php

extract(component_props(
    required: ['audios'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Послание поддержки',
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
    'slot' => 'Начать',
    'class' => 'w-fit mt-10 mx-auto',
]) ?>
<?php $slot1 = ob_get_clean(); ?>

<?php ob_start(); ?>

<h2 class='text-white text-xl md:text-2xl lg:text-3xl'>Hello world</h2>

<?php slot('components/web/layout/planet-spinner', [
    'count' => count($audios),
    'ratio' => 12,
    'gap' => 1.8,
]); ?>
<?php foreach ($audios as $idx => $audio) : ?>
    <li data-file="<?= $audio->file ?>"
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

<div>hello</div>
<?php $slot2 = ob_get_clean(); ?>

<?= component('web/layout/split', [
    'slot1' => $slot1,
    'slot2' => $slot2,
]); ?>

<?php end_slot(); ?>

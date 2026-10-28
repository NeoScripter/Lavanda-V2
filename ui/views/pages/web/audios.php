<?php

extract(component_props(
    required: ['audios'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance(); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.послание_поддержки"),
]); ?>

<?php ob_start(); ?>

<h1><?= $hive->get("web.послание_поддержки_от_автора") ?>
</h1>

<div class='space-y-[1em] text-center text-balance max-w-200 mx-auto'>
    <p>
        <?= $hive->get('web.здесь_вы_можете_услышать_короткие_или_не_очень_голосовые_записи_от_автора_каждая_запись_звучит_как_доверительный_разговор_это_особенный_раздел_ведь_в_каждое_сообщение_в_разное_время_автор_вложила_кусочек_своей_души_и_тепла_откровение_или_личный_опыт_а_некоторые_истории_вы_услышите_первыми') ?>
    </p>

    <p>
        <?= $hive->get("web.состав_аудиозаписей_постоянно_обновляется_некоторые_размещаются_на_ограниченное_время_не_пропустите_именно_ваше_послание") ?>

    </p>
</div>

<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => $hive->get("web.начать"),
    'class' => 'w-fit mt-10 mx-auto',
    'attrs' => [
        'cmp-audio-btn' => true,
        'data-repeat-label' => $hive->get("web.повторить")
    ]
]) ?>
<?php $slot1 = ob_get_clean(); ?>

<?php ob_start(); ?>

<div cmp-audio-wrapper class='flex h-full flex-col justify-center gap-6'>
    <h2 cmp-audio-description class='text-white empty:hidden text-xl md:text-2xl lg:text-3xl'></h2>

    <?php if (! empty($audios)) : ?>

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

    <?php endif; ?>
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

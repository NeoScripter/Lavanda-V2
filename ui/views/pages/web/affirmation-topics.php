<?php

extract(component_props(
    required: ['topics'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.настрой"),
]); ?>

<?php ob_start(); ?>

<div class='flex flex-col h-full justify-center gap-6'>
    <h1><?= $hive->get("web.войти_в_нужный_настрой") ?>
    </h1>

    <div class='space-y-[1em] text-center text-balance max-w-200 mx-auto'>
        <p><?= $hive->get("web.настрой_это_то_с_чего_все_начинается") ?>
        </p>
        <p>
            <?= $hive->get('web.замечали_как_несколько_слов_способны_изменить_взгляд_на_происходящее_вернуть_спокойствие_вдохновение_или_уверенность') ?>
        </p>
        <p><?= $hive->get("web.выбери_тему_и_откройте_своё_послание_на_сегодня_пусть_оно_станет_точкой_опоры_на_весь_день_девизом_или_лозунгом") ?>
        </p>
    </div>
</div>
<?php $slot1 = ob_get_clean(); ?>

<?php ob_start(); ?>

<ul class='max-h-140 overflow-y-auto flex flex-col gap-4 sm:gap-6 py-6 justify-center items-center'>
    <?php foreach ($topics as $topic) : ?>
        <li>
            <a href="<?= $hive->alias('affirmations', $hive->PARAMS, ['topic' => urlencode($topic)]) ?>"
                class='uppercase text-white text-lg hover:bg-primary sm:text-2xl min-w-55 sm:min-w-80 shadow-[10px_10px_20px_#00000040,0_1.5px_1px_#e1d4ff_inset] backdrop-blur-sm px-[1.5em] py-[0.75em] transition-colors bg-linear-[180deg,#c8b5ff42,#ffffff30] flex items-center justify-center rounded-full'>
                <?= $topic ?>
            </a>
        </li>

    <?php endforeach; ?>
</ul>

<?php $slot2 = ob_get_clean(); ?>

<?= component('web/layout/split', [
    'slot1' => $slot1,
    'slot2' => $slot2,
    'class' => '[&>*:last-child]:lg:pb-(--pt-lg)',
    'bg_img' => '/assets/images/shared/backgrounds/split/waves-pattern-mb2x.webp'
]); ?>

<?php end_slot(); ?>

<?php

extract(component_props(
    required: ['src'],
    optional: ['figcaption' => null, 'class' => ''],
    props: get_defined_vars(),
));

$hive = \Base::instance();
?>

<figure cmp-audio-player class="<?= cc('', $class) ?>">
    <?php if ($figcaption) : ?>
        <figcaption class='sr-only'><?= $figcaption ?></figcaption>
    <?php endif; ?>
    <audio class='sr-only' controls playsinline src="<?= $src ?>">
        <a href="<?= $src ?>"> 
            qquila1Скачать аудио qquila2
        </a>
    </audio>
    <div class='max-w-sm mx-auto'>
        <div class='flex items-center justify-center text-white text-xs gap-4'>
            <span cmp-start-time class='block w-fit'>
                00:00
            </span>
            <input type="range" step="1" min="0" class='accent-white min-w-0 w-full block' value="0" />
            <span cmp-end-time class='block w-fit'>
                00:00
            </span>
        </div>
        <button cmp-play-audio-btn class='mt-4 size-10 flex items-center justify-center rounded-full border border-white bg-white mx-auto cursor-pointer transition-transform hover:scale-105 text-[#b9b2cb] [&>svg]:fill-[#b9b2cb]'>
            <?= svg('play') ?>
        </button>
        <button cmp-pause-audio-btn class='mt-4 hidden size-10 flex items-center justify-center rounded-full border border-white bg-white mx-auto cursor-pointer transition-transform hover:scale-105 text-[#b9b2cb] [&>svg]:fill-[#b9b2cb]'>
            <?= svg('pause') ?>
        </button>
    </div>
</figure>

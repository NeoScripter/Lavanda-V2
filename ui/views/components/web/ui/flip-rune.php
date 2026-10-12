<?php
$hive = \Base::instance();

extract(component_props(
    required: ['rune'],
    optional: ['class' => '', 'isPickable' => 'false', 'idx' => 0],
    props: get_defined_vars(),
)); ?>

<li cmp-flip-rune
    cmp-rune
    data-id="<?= $rune['id'] ?>"
    data-name="<?= $rune['name'] ?>"
    data-front-img-src="<?= $rune['front_src'] ?>"
    data-front-img-alt="<?= $rune['front_alt'] ?>"
    data-back-img-src="<?= $rune['back_src'] ?>"
    data-back-img-alt="<?= $rune['back_alt'] ?>"
    style="--index: <?= $idx ?>;"
    class="<?= cc('relative aspect-square group select-none overflow-clip rounded-xl transition-transform duration-300 ease-in-out shrink-0 [:not(.flipped):has([cmp-pickable-item]:not(.hidden))]:hover:z-2 [:not(.flipped):has([cmp-pickable-item]:not(.hidden))]:hover:scale-110 col-start-2 col-end-2 row-start-2 row-start-2', $class) ?>">
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => $rune['front_src'],
        'alt'     => $rune['front_alt'],
        'lazy' => false,
        'prt_class' => 'size-full bg-contain! absolute! transition-transform rotate-y-180 backface-hidden inset-0',
        'img_class' => 'object-contain!',
    ]) ?>
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => $rune['back_src'],
        'alt'     => $rune['back_alt'],
        'lazy' => false,
        'prt_class' => 'size-full bg-contain! isolate backface-hidden transition-transform',
        'img_class' => 'object-contain!',
    ]) ?>
    <?php if ($isPickable === true) : ?>
        <button cmp-pickable-item
            cmp-visible-at-start
            cmp-visible-during
            class='absolute cursor-pointer inset-0 group-[.flipped]:hidden'>
            <span class='absolute border border-white/50 block size-1/3 rounded-full bg-primary m-auto inset-0'></span>
        </button>
    <?php endif; ?>
</li>

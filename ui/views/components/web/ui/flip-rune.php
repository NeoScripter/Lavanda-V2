<?php
$hive = \Base::instance();

extract(component_props(
    required: ['rune'],
    optional: ['class' => '', 'isPickable' => 'false'],
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
    class="<?= cc('relative aspect-square overflow-clip rounded-xl shrink-0', $class) ?>">
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => $rune['front_src'],
        'alt'     => $rune['front_alt'],
        'prt_class' => 'size-full bg-contain! absolute! transition-transform rotate-y-180 backface-hidden inset-0',
        'img_class' => 'object-contain!',
    ]) ?>
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => $rune['back_src'],
        'alt'     => $rune['back_alt'],
        'prt_class' => 'size-full bg-contain! isolate backface-hidden transition-transform',
        'img_class' => 'object-contain!',
    ]) ?>
    <?php if ($isPickable === true) : ?>
        <button cmp-pickable-item
            cmp-visible-at-start
            cmp-visible-during
            class='absolute z-1 cursor-pointer inset-0'></button>
    <?php endif; ?>
</li>

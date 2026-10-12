<?php
$hive = \Base::instance();

extract(component_props(
    required: ['rune'],
    optional: ['class' => '', 'side' => 'back', 'idx' => 1],
    props: get_defined_vars(),
)); ?>

<li cmp-rune
    data-id="<?= $rune['id'] ?>"
    data-front-img-src="<?= $rune['front_src'] ?>"
    data-front-img-alt="<?= $rune['front_alt'] ?>"
    data-back-img-src="<?= $rune['back_src'] ?>"
    data-back-img-alt="<?= $rune['back_alt'] ?>"
    class="<?= cc('relative select-none aspect-square rounded-xl shrink-0', $class) ?>"
    style="--index: <?= $idx ?>;">
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => $rune[$side . '_src'],
        'alt'     => $rune[$side . '_alt'],
        'lazy' => false,
        'prt_class' => 'size-full bg-contain! isolate transition-transform',
        'img_class' => 'object-contain!',
    ]) ?>
</li>

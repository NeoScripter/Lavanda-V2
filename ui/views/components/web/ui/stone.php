<?php
$hive = \Base::instance();

extract(component_props(
    required: ['stone'],
    optional: ['class' => '', 'idx' => 0],
    props: get_defined_vars(),
)); ?>

<li cmp-stone
    cmp-flip-rune
    style="--index: <?= $idx ?>;"
    class="<?= cc('relative aspect-square group select-none overflow-clip rounded-xl transition-transform duration-300 ease-in-out shrink-0 col-start-2 col-end-2 row-start-2 row-start-2', $class) ?>">
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => $stone['preview_src'],
        'alt'     => $stone['preview_alt'],
        'lazy' => false,
        'prt_class' => 'size-full bg-contain! isolate',
        'img_class' => 'object-contain!',
    ]) ?>
</li>

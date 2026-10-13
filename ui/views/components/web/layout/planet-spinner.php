<?php

extract(component_props(
    required: ['count', 'slot'],
    optional: ['attrs' => [], 'ratio' => 11, 'gap' => 2, 'class' => ''],
    props: get_defined_vars(),
)); ?>

<div cmp-visible-at-start
    cmp-visible-during
    cmp-planet-spinner
    class="<?= cc('aspect-2/1 mx-auto w-full max-w-206 relative', $class) ?>">
    <ul
        cmp-item-list
        data-item-size-ratio="<?= $ratio ?>"
        style="--count: <?= $count ?>;--offset: 0; --gap: <?= $gap ?>;"

        class='size-full relative z-1' <?= serialize_attrs($attrs) ?>>
        <span cmp-planet-bg aria-hidden="true" class='absolute inset-0 -z-10 before:absolute after:-z-10 before:size-[120%] before:-z-15 before:bg-radial-(--bg-danger-muted) before:left-1/2 before:top-1/2 before:-translate-1/2 after:absolute after:aspect-square after:h-full after:bg-linear-(--bg-primary-fluid) after:rounded-full after:mx-auto after:left-1/2 after:-translate-x-1/2 after:inset-y-0'></span>
        <?= $slot ?>
    </ul>
</div>

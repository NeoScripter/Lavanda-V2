<?php

extract(component_props(
    required: ['count', 'slot'],
    optional: ['attrs' => []],
    props: get_defined_vars(),
)); ?>

<div cmp-planet-spinner class='aspect-2/1 mx-auto w-full max-w-206 relative'>
    <ul
        cmp-visible-at-start
        cmp-visible-during
        style="--count: <?= $count ?>;"

        class='size-full relative z-1' <?= serialize_attrs($attrs) ?>>
        <?= $slot ?>
        <span class='absolute inset-0 -z-10 before:absolute after:-z-10 before:size-[120%] before:bg-radial-(--bg-danger-muted) before:left-1/2 before:top-1/2 before:-translate-1/2 after:absolute after:aspect-square after:h-full after:bg-linear-(--bg-primary-fluid) after:rounded-full after:mx-auto after:left-1/2 after:-translate-x-1/2 after:inset-y-0 '></span>
    </ul>
</div>

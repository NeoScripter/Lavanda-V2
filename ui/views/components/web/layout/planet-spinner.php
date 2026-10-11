<?php

extract(component_props(
    required: ['count', 'slot'],
    optional: ['attrs' => []],
    props: get_defined_vars(),
)); ?>

<div cmp-planet-spinner class='aspect-2/1 before:absolute before:size-[120%] before:bg-radial-(--bg-danger-muted) before:left-1/2 before:top-1/2 before:-translate-1/2 mx-auto after:absolute after:aspect-square after:h-full after:bg-linear-(--bg-primary-fluid) after:rounded-full after:mx-auto after:left-1/2 after:-translate-x-1/2 after:inset-y-0 w-full max-w-206 perspective-midrange relative'>
    <ul
        cmp-visible-at-start
        cmp-visible-during
        style="--count: <?= $count ?>;"

        class='inset-0 bg-red-400 absolute size-full' <?= serialize_attrs($attrs) ?>>
        <?= $slot ?>
    </ul>
</div>

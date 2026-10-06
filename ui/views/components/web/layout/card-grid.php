<?php

extract(component_props(
    required: ['slot'],
    optional: ['gap' => 2.5, 'width' => 10, 'attrs' => []],
    props: get_defined_vars(),
)); ?>

<ul
    cmp-card-grid
    cmp-visible-at-start
    cmp-visible-during
    style="--card-w: <?= $width ?>rem; --gap: <?= $gap ?>rem; --card-h: <?= $width / 224 * 319 ?>rem; --rows: 20;"
    class='grid gap-x-(--gap) grid-rows-[repeat(var(--rows),calc(var(--card-h)/3))] grid-cols-[repeat(auto-fill,var(--card-w))] justify-center [&>li[nth-2]]:-translate-x-1/3 [&>li]:transition-transform [&>li]:duration-300 [&>li[nth-3]]:translate-x-1/3' <?= serialize_attrs($attrs) ?>>
    <?= $slot ?>
</ul>

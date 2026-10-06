<?php

extract(component_props(
    required: ['count', 'slot'],
    optional: ['gap' => 0.4, 'width' => 10, 'attrs' => []],
    props: get_defined_vars(),
)); ?>

<?php if ($count > 0) : ?>
    <ul
        cmp-visible-at-start
        cmp-visible-during
        style="--card-size: <?= $width ?>rem; --gap: <?= $gap ?>rem; --count: <?= $count ?>;"
        class='grid [&>li]:w-(--card-size) max-w-[calc((var(--count)+1)*var(--gap)+var(--card-size))] grid-cols-[repeat(auto-fill,var(--gap))] pr-(--card-size) gap-y-1 mx-auto' <?= serialize_attrs($attrs) ?>>
        <?= $slot ?>
    </ul>
<?php else: ?>
    <p>Cards are not loaded yet :(</p>
<?php endif; ?>

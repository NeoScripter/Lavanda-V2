<?php

extract(component_props(
    required: [],
    optional: ['class' => ''],
    props: get_defined_vars(),
)); ?>

<ul cmp-selected-items class="<?= cc('flex flex-wrap justify-center empty:invisible gap-4 [&>li]:max-w-40 [&>li]:w-full', $class) ?>">
</ul>

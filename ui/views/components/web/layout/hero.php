<?php

extract(component_props(
    required: ['slot'],
    optional: ['class' => '', 'style' => null],
    props: get_defined_vars(),
)); ?>

<div class="pt-(--pt-lg) px-4 sm:px-18 rounded-primary pb-19 sm:pb-38 shadow-accent relative isolate lg:pb-31 xl:pb-48 xl:px-45 full-bleed sm:w-[calc(100%-var(--px-sm)*2)]! mx-auto bg-no-repeat <?= $class ?>" <?= $style ? "style=\"$style\"" : '' ?>>
    <?= $slot ?>
</div>

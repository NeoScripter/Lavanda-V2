<?php

extract(component_props(
    required: ['slot'],
    optional: ['class' => '', 'style' => null],
    props: get_defined_vars(),
)); ?>

<div class="pt-35 px-4 sm:px-18 rounded-primary sm:pt-66 lg:pt-56 pb-19 sm:pb-38 shadow-accent relative isolate lg:pb-31 xl:pb-48 xl:pt-42 xl:px-45 full-bleed sm:w-[calc(100%-var(--padding-outer-sm)*2)]! mx-auto bg-no-repeat <?= $class ?>" <?= $style ? "style=\"$style\"" : '' ?>>
    <?= $slot ?>
</div>

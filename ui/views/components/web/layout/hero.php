<?php

extract(component_props(
    required: ['slot'],
    optional: ['class' => '', 'style' => null],
    props: get_defined_vars(),
)); ?>

<div class='pt-21.5 px-4 sm:px-18 rounded-primary sm:pt-44 lg:pt-31 pb-19 sm:pb-38 shadow-accent relative isolate lg:pb-31 xl:pb-48 xl:pt-35 xl:px-45 full-bleed bg-primary/20 sm:w-[calc(100%-var(--padding-outer-sm)*2)]! mx-auto' <?= $style ? "style=\"$style\"" : '' ?>>
    <?= $slot ?>
</div>

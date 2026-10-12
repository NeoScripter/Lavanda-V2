<?php

extract(component_props(
    required: ['slot1', 'slot2'],
    optional: ['class' => ''],
    props: get_defined_vars(),
)); ?>

<div class="<?= cc('flex flex-col lg:flex-row *:px-4 *:sm:px-12 rounded-primary *:pb-19 shadow-accent relative isolate full-bleed sm:w-[calc(100%-var(--px-sm)*2)]! overflow-clip mx-auto bg-no-repeat', $class) ?>">
    <article class='flex-1 pt-(--pt-lg) bg-white bg-no-repeat bg-cover bg-center'
        style="background-image: url(/assets/images/shared/backgrounds/split/split-pattern-mb2x.webp);">
        <?= $slot1 ?>
    </article>
    <article class='flex-1 bg-linear-(--bg-primary) flex flex-col pt-19 lg:pt-(--pt-lg) justify-between gap-6 overflow-x-clip'>
        <?= $slot2 ?>
    </article>
</div>

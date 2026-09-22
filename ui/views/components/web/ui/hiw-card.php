<?php
$hive = \Base::instance();

extract(component_props(
    required: ['slot', 'idx'],
    optional: ['class' => ''],
    props: get_defined_vars(),
)); ?>

<li class='grid-rows-[min(18rem,80vw)_1fr] grid xl:text-lg <?= $class ?>'>
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'alt' => 'Stairs',
        'path'     => "/assets/images/pages/home/how_it_works/how_it_works_$idx",
        'prt_class' => 'mx-auto size-[min(90vw,21.5rem)] xs:size-[min(90vw,22rem)] ',
        'img_class' => 'size-full object-contain!',
    ]) ?>

    <article class='shadow-accent px-[1.5em] pb-10 pt-[min(5rem,16vw)] h-fit rounded-2xl mx-auto xl:[&_p]:text-lg [&>div]:space-y-[1em] max-w-110 lg:max-w-auto lg:[&_h3]:text-3xl'>
        <?= $slot ?>
    </article>

</li>

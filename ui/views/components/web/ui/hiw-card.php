<?php
$hive = \Base::instance();

extract(component_props(
    required: ['slot', 'idx'],
    optional: ['class' => ''],
    props: get_defined_vars(),
)); ?>

<li class='[--sq-size:min(90vw,20rem)] mt-[calc(var(--sq-size)/-5)] <?= $class ?>'>
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'alt' => 'Stairs',
        'path'     => "/assets/images/pages/home/how_it_works/how_it_works_$idx",
        'prt_class' => 'mx-auto size-(--sq-size) -translate-y-[calc(var(--sq-size)/-5)] bg-contain!',
        'img_class' => 'size-full object-contain!',
    ]) ?>

    <article class='shadow-accent px-[1.5em] pb-10 pt-[calc(1.25rem+(var(--sq-size)/5))] h-fit rounded-2xl mx-auto [&>div]:space-y-[1em] max-w-110 lg:max-w-auto lg:[&_h3]:text-3xl'>
        <?= $slot ?>
    </article>

</li>

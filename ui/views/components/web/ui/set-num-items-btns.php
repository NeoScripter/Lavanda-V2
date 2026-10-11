<?php extract(component_props(
    required: ['items'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<ul
    class="grid [--sq-size:min(100%,20.6rem)] md:[--sq-size:25.6rem] -mt-12 sm:-mt-25 px-2 relative grid-cols-[repeat(auto-fit,var(--sq-size))] justify-center gap-8 md:gap-10">

    <?php foreach ($items as $idx => $item) : ?>
        <?= component('web/ui/practice-item-card', [
            'item' => $item,
            'class' => 'justify-center' . ($idx === 2 ? ' md:col-span-2 md:max-w-(--sq-size) md:mx-auto xl:col-span-1' : ''),
            'max_char' => 150,
            'attrs' => ['data-num-rounds' => $item['num'], 'cmp-reveal-game-btn' => true]
        ]) ?>
    <?php endforeach; ?>

</ul>

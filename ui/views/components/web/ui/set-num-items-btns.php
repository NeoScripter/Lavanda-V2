<?php extract(component_props(
    required: ['items'],
    optional: [],
    props: get_defined_vars(),
)); ?>


<ul
    class="flex flex-wrap [--sq-size:min(100%,20.6rem)] md:[--sq-size:25.6rem] -mt-12 sm:-mt-25 px-2 relative justify-center gap-8 md:gap-10">

    <?php foreach ($items as $idx => $item) : ?>
        <?= component('web/ui/practice-item-card', [
            'item' => $item,
            'class' => 'justify-center max-w-100 w-full',
            'max_char' => 150,
            'attrs' => ['data-num-rounds' => $item['num'], 'cmp-reveal-game-btn' => true]
        ]) ?>
    <?php endforeach; ?>

</ul>

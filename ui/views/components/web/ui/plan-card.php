<?php

use Enums\PlanSlug;

extract(component_props(
    required: ['item'],
    optional: ['class' => '', 'as' => 'li', 'url' => '', 'button' => null],
    props: get_defined_vars()
)); ?>

<<?= $as ?> class="<?= cc('bg-white shadow-accent rounded-2xl px-7.5 pb-9 w-full max-w-75 text-balance flex flex-col gap-4 relative pt-28', $class) ?>">
    <?= component('shared/ui/image', [
        'sizes' => 'mb',
        'path' => $item['image'],
        'prt_class' => 'bg-contain! w-[130%] aspect-video absolute! top-0 left-1/2 -translate-1/2',
        'img_class' => 'object-contain',
    ]) ?>

    <h2 class='text-xl!'><?= PlanSlug::from($item['slug'])->label() ?></h2>
    <div class='mb-8 text-center text-balance'>
        <p class='font-bold text-base! mb-[0.5em]'><?= $item['headline'] ?></p>
        <p class='text-base!'><?= $item['description'] ?></p>
    </div>
    <p class='text-primary font-medium text-center text-lg md:text-xl xl:text-2xl mt-auto'><?= $item['price'] ?>₽</p>

    <?php if (! empty($button)) : ?>
        <?= $button ?>
    <?php endif; ?>

</<?= $as ?>>

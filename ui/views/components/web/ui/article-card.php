<?php

extract(component_props(
    required: ['article'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<li class="flex flex-col gap-4 shadow-accent rounded-xl p-6 sm:gap-6 sm:p-8 bg-white/70">

    <div class="relative w-full">
        <?= component('shared/ui/image', [
            'sizes'    => 'mb',
            'path'     => $article['preview']['src'],
            'prt_class' => 'w-full shrink-0 rounded-xl aspect-3/2',
        ]) ?>
    </div>

    <p class="mb-2 xl:text-lg"><?= mb_substr($article['description'], 0, 120) . '...' ?></p>

    <?= component('web/ui/button', [
        'size' => 'sm',
        'variant' => 'outline',
        'slot' => 'Перейти',
        'class' => 'mt-auto font-semibold'
    ]) ?>
</li>

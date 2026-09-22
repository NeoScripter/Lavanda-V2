<?php

extract(component_props(
    required: ['items'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Практика',
    'class' => "bg-primary-muted/50 pt-0!"
]); ?>

<!-- Hero Section -->
<section class='bg-white/90 full-bleed pt-[calc(var(--pt-lg)+var(--px-sm))] relative z-1 px-6 pb-10 sm:px-16 sm:pb-16 lg:max-w-208 lg:px-18 lg:pb-18 xl:max-w-263 xl:pb-22.5 xl:px-20 sm:rounded-b-2xl sm:max-w-177 mx-auto'>

    <h1>Практика</h1>
    <p class='text-center text-balance'>Иногда решение приходит не тогда, когда мы мучительно думаем о нём, а когда даём себе немного тишины и внимания. Или делаем анализ и рассчет отодвигая тревоги в сторону. Этот раздел — набор простых практик, которые помогут остановиться, настроиться на себя и яснее услышать внутренний голос.</p>
</section>


<section class='relative full-bleed'>
    <?= component('shared/ui/image', [
        'sizes'    => 'mb|tb|dk',
        'alt' => 'Composition',
        'path'     => '/assets/images/pages/practice/hero-fg',
        'prt_class' => 'w-full aspect-square absolute! inset-0 m-auto md:w-9/10 lg:w-4/5 bg-contain!',
        'img_class' => 'size-full object-contain!',
    ]) ?>

</section>

<!-- items -->
<section>
    <?php if (! empty($items)) : ?>
        <ul class="grid [--sq-size:17.875rem] grid-cols-[repeat(auto-fill,min(100%,var(--sq-size)))] xl:grid-cols-4 justify-center gap-8">

            <?php foreach ($items as $item) : ?>
                <?php $item['title']; ?>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_items_here_yet') ?></p>
    <?php endif; ?>
</section>
<?php end_slot(); ?>

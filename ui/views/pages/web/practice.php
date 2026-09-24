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
        'prt_class' => 'w-full aspect-square absolute! inset-0 m-auto md:w-9/10 translate-y-1/8 sm:translate-y-0 lg:w-4/5 bg-contain!',
        'img_class' => 'size-full object-contain!',
    ]) ?>

</section>

<span></span>

<?php $s_item = $items[2]->to_resource(); ?>
<!-- Items -->
<section>
    <?php if (! empty($items)) : ?>
        <ul class="grid [--sq-size:min(100%,20.6rem)] md:[--sq-size:25.6rem] relative grid-cols-[repeat(auto-fill,var(--sq-size))] justify-center gap-8 md:gap-10">

            <?php foreach (array_slice($items, 0, 2) as $item) : ?>
                <?= component('web/ui/practice-item-card', compact('item')) ?>
            <?php endforeach; ?>

            <li class='col-start-1 -col-end-1 xl:-mx-[calc(var(--px-lg)/2)] xs:-mx-(--px-lg) isolate relative before:absolute before:-z-1 py-7 sm:py-10 lg:py-12 2xl:py-13 before:bg-background-muted before:inset-y-0 before:left-1/2 before:-translate-x-1/2 before:w-screen flex flex-col gap-12 sm:gap-14 lg:gap-23 lg:flex-row 2xl:gap-49 lg:justify-between'>
                <?= component('shared/ui/image', [
                    'sizes'    => 'mb|tb',
                    'alt' => $item['image_alt'],
                    'path'     => $item['image_src'],
                    'prt_class' => '!bg-contain lg:order-1 shrink-0 lg:max-w-1/2 xl:max-w-168 xl:w-full',
                    'img_class' => 'size-full object-contain!',
                ]) ?>
                <div class='space-y-6 lg:space-y-8'>
                    <h3 class='sm:text-left'><?= $item['title'] ?></h3>
                    <p class='text-center text-balance sm:text-left'><?= $item['description'] ?></p>

                    <?php if ($item['file']) : ?>
                        <?= component('web/ui/file-link', ['url' => $item['file'], 'label' => 'Скачать файл', 'class' => 'mx-auto sm:mx-0 mb-[0.75em]']) ?>
                    <?php endif; ?>

                    <div>
                        <?php foreach ($s_item['faqs'] as $idx => $faq) : ?>
                            <details name="faqs" <?= $idx === 0 ? 'open' : '' ?> class='border-b border-gray-400 py-[1em] px-[0.5em]'>
                                <summary class='cursor-pointer font-semibold'><?= ($idx + 1) . '. ' . $faq['question'] ?></summary>
                                <p class='py-[1em]'><?= $faq['answer'] ?></p>
                            </details>
                        <?php endforeach; ?>
                    </div>
                </div>
            </li>

            <?php if (count($items) > 2) : ?>
                <?php foreach (array_slice($items, 2) as $item) : ?>
                    <?= component('web/ui/practice-item-card', compact('item')) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_items_here_yet') ?></p>
    <?php endif; ?>
</section>
<?php end_slot(); ?>

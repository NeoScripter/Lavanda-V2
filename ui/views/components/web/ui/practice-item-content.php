<?php

extract(component_props(
    required: ['item'],
    optional: [],
    props: get_defined_vars(),
));

$item = $item->to_resource();
?>


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
            <?php foreach ($item['faqs'] as $idx => $faq) : ?>
                <details name="faqs" <?= $idx === 0 ? 'open' : '' ?> class='border-b border-gray-400 py-[1em] px-[0.5em]'>
                    <summary class='cursor-pointer font-semibold'><?= ($idx + 1) . '. ' . $faq['question'] ?></summary>
                    <p class='py-[1em]'><?= $faq['answer'] ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</li>

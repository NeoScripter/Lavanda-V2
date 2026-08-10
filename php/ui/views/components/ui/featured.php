<?php $title = explode(' ', $title ?? ''); ?>

<?php if ($shown ?? false) : ?>
    <section class="app-section border-t border-b border-white/20 full-bleed px-(--px) bg-linear-to-r from-neutral-900 to-zinc-900 text-white">
        <h2 class="text-inherit text-balance mb-6 xl:mb-8"><?= implode(' ', array_slice($title, 0, -1)) ?>
            <span class="text-accent"><?= array_last($title) ?></span>
        </h2>
        <p class="text-inherit text-balance text-center max-w-[85ch] mx-auto xl:text-2xl"><?= $subtitle ?? '' ?></p>

        <div class="mt-(--py) bg-neutral-800 rounded-sm px-(--px) sm:px-6 xl:px-12 py-6 md:py-8 xl:py-12 md:gap-8 xl:gap-12 md:flex md:items-start justify-between">

            <div class="mb-8 md:mb-8 max-w-full xl:mb-10 prose text-white! [&_strong]:text-white! xl:prose-lg">
                <?= isset($html) ? html_entity_decode($html) : '' ?>
            </div>

            <?php if (isset($image['src'])) : ?>
                <?= component('ui/image', [
                    'sizes'    => 'mb',
                    'path'     => $image['src'],
                    'alt'     => $image['alt'],
                    'prt_class' => 'w-full h-100 rounded-lg md:basis-1/3 shrink-0 md:h-90',
                    'img_class' => ''
                ]) ?>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php $uid = uniqid('gallery_'); ?>

<?php if (! empty($gallery)): ?>
    <section class="<?= $class ?? '' ?>">
        <ul
            component-gallery
            class="flex flex-wrap"
            style="gap: 12px">
            <?php foreach ($gallery as $img): ?>
                <?php $modal_id = uniqid('gallery_modal_'); ?>

                <li class="relative group shrink-0">
                    <?= component('ui/image', [
                        'path' => $img['src'],
                        'alt' => $img['alt'],
                        'sizes' => 'mb',
                        'prt_class' => 'rounded-xl h-30 sm:h-40 md:h-50',
                    ]) ?>
                    <span class="absolute rounded-xl bg-black/25 transition-opacity group-hover:opacity-0 inset-0 size-full block"></span>
                    <button
                        component-modal-show
                        data-modal-id="<?= $modal_id ?>"
                        component-gallery-trigger
                        type="button" class="absolute inset-0 size-full">
                    </button>
                </li>

                <?php slot('components/layout/modal', ['modal_id' => $modal_id]); ?>

                <div
                    component-gallery-modal
                    data-images="<?= htmlspecialchars(json_encode(array_map(fn($img) => $img->src, $gallery))) ?>">
                    <button
                        component-prev-btn
                        class="size-12 hidden md:block absolute left-0 my-auto -translate-x-full inset-y-0 rotate-180 text-white">
                        <?= svg('chevron-right') ?>
                    </button>
                    <figure class="w-[80dvw] h-[70dvh] animate-expand closes-on-click">
                        <img
                            component-image
                            src="<?= $img->src . '-dk.webp' ?>"
                            class="object-contain transition-[opacity,scale] duration-500 ease-in-out mx-auto w-fit h-full closes-on-click" alt="">
                    </figure>
                    <button
                        component-next-btn
                        class="size-12 hidden md:block absolute right-0 my-auto translate-x-full inset-y-0 text-white">
                        <?= svg('chevron-right') ?>
                    </button>
                </div>

                <?php end_slot(); ?>

            <?php endforeach; ?>
        </ul>

    </section>

<?php endif; ?>

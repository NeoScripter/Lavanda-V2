<?php
extract(component_props(
    required: ['path', 'sizes'],
    optional: [
        'prt_class' => '',
        'img_class' => '',
        'overlay_class' => '',
        'avif' => true,
        'alt' => ''
    ],
    props: get_defined_vars(),
));

$uid = 'aimg-' . uniqid();
?>
<div
    component-adaptive-image
    id="<?= $uid ?>"
    class="overflow-clip image bg-cover bg-center bg-no-repeat relative <?= $prt_class ?? '' ?>">
    <style>
        #<?= $uid ?> {
            background-image: <?= "url({$path}-mb-tiny.webp)" ?>;
        }

        <?php if ($avif && str_contains($sizes, 'tb')): ?>@media screen and (min-width: 31.25rem) {
            #<?= $uid ?> {
                background-image: <?= "url({$path}-tb-tiny.webp)" ?>;
            }
        }

        <?php endif ?><?php if ($avif && str_contains($sizes, 'dk')): ?>@media screen and (min-width: 64rem) {
            #<?= $uid ?> {
                background-image: <?= "url({$path}-dk-tiny.webp)" ?>;
            }
        }

        <?php endif ?>
    </style>

    <picture>
        <?php if ($avif && str_contains($sizes, 'dk')): ?>
            <source
                type="image/avif"
                srcset="<?= build_src_set($path, 'dk', 'avif') ?>"
                media="(min-width: 64rem)" />
        <?php endif ?>

        <?php if (str_contains($sizes, 'dk')): ?>
            <source
                type="image/webp"
                srcset="<?= build_src_set($path, 'dk', 'webp') ?>"
                media="(min-width: 64rem)" />
        <?php endif ?>

        <?php if ($avif && str_contains($sizes, 'tb')): ?>
            <source
                type="image/avif"
                srcset="<?= build_src_set($path, 'tb', 'avif') ?>"
                media="(min-width: 31.25rem)" />
        <?php endif ?>

        <?php if (str_contains($sizes, 'tb')): ?>
            <source
                type="image/webp"
                srcset="<?= build_src_set($path, 'tb', 'webp') ?>"
                media="(min-width: 31.25rem)" />
        <?php endif ?>

        <?php if ($avif && str_contains($sizes, 'mb')): ?>
            <source
                type="image/avif"
                srcset="<?= build_src_set($path, 'mb', 'avif') ?>" />
        <?php endif ?>

        <img
            srcset="<?= build_src_set($path, 'mb', 'webp') ?>"
            loading="lazy"
            alt="<?= $alt ?>"
            class="block transition-opacity duration-500 ease-in opacity-0 size-full object-cover object-center <?= $img_class ?? '' ?>" />
    </picture>

    <div
        component-overlay
        aria-hidden="true"
        class="animate-loading absolute inset-0 size-full bg-white/15 <?= $overlay_class ?? '' ?>"></div>
</div>

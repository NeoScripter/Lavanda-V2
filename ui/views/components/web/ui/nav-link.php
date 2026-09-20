<?php

extract(component_props(
    required: ['label'],
    optional: ['class' => '', 'url' => null],
    props: get_defined_vars(),
));

$base_class = 'flex items-center justify-center isolate relative xl:text-base';
$uid = uniqid('popover_');
?>
<li class='<?= $class ?>'>
    <?php if (isset($url)) : ?>
        <a
            href="<?= $url ?>"
            class="<?= $base_class ?> <?= $url === \Base::instance()->PATH ? 'font-semibold md:before:absolute md:before:-inset-x-2 md:before:-inset-y-0.5 md:before:bg-gray-50 md:before:rounded-sm md:before:-z-1' : 'hover:underline underline-offset-4' ?>">
            <?= $label ?>
        </a>
    <?php else : ?>
        <button
            popovertarget="<?= $uid ?>"
            class="<?= $base_class ?> group flex relative items-center mx-auto w-fit"
            style="anchor-name: --nav;">
            <span class="absolute popover-underscore inline-block h-0.5 rounded-sm transition-[width] ease-in-out duration-350 group-hover:w-full w-1/2 bg-current bottom-0 translate-y-[200%] left-0"></span>
            <span><?= $label ?></span>
        </button>

        <div
            id="<?= $uid ?>"
            popover
            class="bg-white rounded-sm shadow-md p-4 max-w-70 w-full">

            <?php if (isset($nav_links)) : ?>
                <nav>
                    <ol class="flex flex-col text-base gap-3 justify-end">
                        <?php foreach ($nav_links as $link) : ?>
                            <?= component('web/ui/nav-link', [...$link, 'class' => 'block! text-balance']) ?>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</li>

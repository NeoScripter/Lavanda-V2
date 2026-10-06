<?php

extract(component_props(
    required: ['heading', 'html', 'image'],
    optional: ['slot' => ''],
    props: get_defined_vars(),
)); ?>

<?php slot('components/web/layout/hero', ['class' => 'bg-background-muted relative']); ?>
<span class='absolute -bottom-px before:left-0 inset-0 before:top-0 overflow-clip before:bg-no-repeat before:aspect-square before:absolute before:bg-contain before:w-3/5 lg:before:w-2/5 block before:bg-[url("/assets/images/shared/hero-game/blob-1.svg")]'></span>
<span class='absolute -bottom-px before:right-0 inset-0 before:top-1/2 before:translate-x-2/3 lg:before:translate-x-1/4 before:-translate-y-1/2 overflow-clip before:bg-no-repeat before:aspect-square before:absolute before:bg-contain before:w-full xs:before:w-4/5 lg:before:w-2/5 block before:bg-[url("/assets/images/shared/hero-game/blob-2.svg")]'></span>
<div class='flex flex-col gap-8 md:gap-12 isolate lg:flex-row lg:items-center'>
    <?= component('shared/ui/image', [
        'sizes'    => 'mb|tb',
        'alt' => 'black-cat',
        'path'     => $image,
        'prt_class' => 'shrink-0 bg-contain! lg:order-2 max-w-xl aspect-square lg:max-w-2/5 2xl:max-w-[min(40%,40rem)] mx-auto lg:w-full',
        'img_class' => 'size-full object-contain',
    ]) ?>

    <div class='space-y-8 md:space-y-12 text-balance'>
        <h1 class='mb-2 text-left'><?= $heading ?></h1>

        <div class='space-y-[1em]'>
            <?= $html ?>
        </div>

        <?= $slot ?>
    </div>
</div>
<?php end_slot(); ?>

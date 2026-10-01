<?php

extract(component_props(
    required: ['heading', 'html', 'image'],
    optional: ['slot' => ''],
    props: get_defined_vars(),
)); ?>

<?php slot('components/web/layout/hero', ['class' => 'bg-background-muted']); ?>
<div class='flex flex-col gap-8 md:gap-12 lg:flex-row lg:items-center'>
    <?= component('shared/ui/image', [
        'sizes'    => 'mb|tb',
        'alt' => 'black-cat',
        'path'     => $image,
        'prt_class' => 'shrink-0 bg-contain! lg:order-2 max-w-xl lg:max-w-2/5 2xl:max-w-[min(50%,40rem)] mx-auto lg:w-full',
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

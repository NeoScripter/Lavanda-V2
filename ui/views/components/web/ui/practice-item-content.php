<template component-pic-template>
    <li
        component-pic
        data-img-src="/assets/images/shared/empty/empty"
        data-img-alt="Empty image alt"
        class='col-start-1 -col-end-1 xl:-mx-[calc(var(--px-lg)/2)] xs:-mx-(--px-lg) isolate relative before:absolute before:-z-1 py-7 sm:py-10 lg:py-12 2xl:py-13 before:bg-background-muted before:inset-y-0 md:px-(--px-lg) lg:px-0 before:left-1/2 before:-translate-x-1/2 before:w-screen flex flex-col gap-12 sm:gap-14 lg:gap-23 lg:flex-row 2xl:gap-49 lg:justify-between'>
        <?= component('shared/ui/image', [
            'sizes'    => 'mb|tb',
            'alt' => "Empty image alt",
            'path'     => '/assets/images/shared/empty/empty',
            'prt_class' => '!bg-contain lg:order-1 shrink-0 lg:max-w-1/2 xl:w-full',
            'img_class' => 'size-full object-contain!',
        ]) ?>
        <div class='space-y-6 lg:space-y-8 lg:mb-12 xl:mb-0'>
            <h3 component-pic-title class='sm:text-left'></h3>
            <p component-pic-description class='text-center text-balance sm:text-left'></p>

            <?= component('web/ui/file-link', ['url' => 'https://example.com', 'label' => 'Скачать файл', 'class' => 'mx-auto sm:mx-0 mb-[0.75em]']) ?>

            <div component-pic-faqs></div>
        </div>
    </li>
</template>

<header
    class="bg-nav-background text-white px-(--px) xl:px-[calc(var(--px)/2)] sticky top-0 md:static z-200 py-2 md:py-3 flex items-center gap-4 md:gap-6 lg:gap-8 xl:gap-10 justify-between bg-no-repeat bg-cover bg-center"
    style="background-image: <?= "url(/assets/imgs/shared/bg-hero/background-hero-neutral.webp)" ?>">

    <a href="/"
        aria-label="Go to homepage"
        class="block size-15 md:size-25 xl:size-30 shrink-0 md:-translate-x-1/4">
        <?= component('ui/image', [
            'sizes'    => 'mb',
            'alt' => 'SRI logo',
            'path'     => '/assets/imgs/shared/logo/logo',
            'prt_class' => 'size-full',
            'overlay_class' => 'rounded-full'
        ]) ?>
    </a>
    <?= component('layout/burger-menu', [
        'class'    => 'md:hidden mr-2 mt-1',
    ]) ?>
    <?= component('layout/nav-menu', [
        'class' => 'hidden md:block'
    ]) ?>
</header>

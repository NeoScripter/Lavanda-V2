<header class="fixed top-4.5 z-10 sm:top-8 xl:top-13 inset-x-(--padding-outer-sm) bg-white rounded-4xl sm:bg-transparent">
    <div class='flex items-center justify-between gap-2 bg-linear-(--bg-primary-pale) sm:bg-none p-4 rounded-full'>
        <figure class='w-31.5 sm:w-52'>
            <img src="/assets/svgs/logo-lg-purple.svg" />
        </figure>

        <?= component('web/ui/nav-menu', ['class' => 'hidden! xl:block!']); ?>

        <?php slot('components/web/ui/button', ['variant' => 'primary', 'class' => 'hidden sm:flex']); ?>
        <?= svg('circle-user') ?>
        Войти
        <?php end_slot(); ?>

        <?= component('web/ui/burger-menu', ['class' => 'text-primary mr-2 sm:hidden']); ?>
    </div>

    <?= component('web/ui/nav-menu', ['class' => 'xl:hidden']); ?>
</header>

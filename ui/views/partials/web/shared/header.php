<?php

use Support\Auth;

$user = Auth::user();
$hive = \Base::instance();

?>
<header
    component-app-header
    class="fixed xs:absolute top-4.5 z-10 sm:top-8 xl:top-13 inset-x-(--px-sm) bg-white rounded-4xl sm:bg-transparent transition-transform">
    <div class='flex items-center justify-between gap-2 bg-linear-(--bg-primary-pale) sm:bg-none p-4 rounded-full'>
        <figure class='w-31.5 sm:w-52 relative'>
            <img src="/assets/svgs/logo-lg-violet.svg" />
            <a href="<?= $hive->alias('home') ?>" class="absolute inset-0"></a>
        </figure>

        <?= component('web/ui/nav-menu', ['class' => 'hidden! xl:block!']); ?>

        <?php if (in_array($hive->ALIAS, ['login'])) : ?>
            <span aria-hidden="true" class='basis-31.5 sm:basis-52'></span>
        <?php elseif (in_array($hive->ALIAS, ['profile'])) : ?>
            <form action="<?= $hive->alias('logout') ?>" method="post" class="my-0.5 mx-1">
                <input type="hidden" name="_method" value="delete">
                <?= csrf() ?>

                <?php slot('components/web/ui/button', [
                    'variant' => 'primary',
                    'class' => 'hidden sm:flex',
                    'attrs' => ['type' => 'submit']
                ]); ?>
                <?= svg('logout') ?>
                Выйти
                <?php end_slot(); ?>
            </form>
        <?php else : ?>
            <?php slot('components/web/ui/button', [
                'variant' => 'primary',
                'class' => 'hidden sm:flex',
                'href' => empty($user) ? $hive->alias('login') : $hive->alias('profile'),
            ]); ?>
            <?= svg('circle-user') ?>
            <?= empty($user) ? 'Войти' : $user['name'] ?>
            <?php end_slot(); ?>
        <?php endif; ?>
        <?= component('web/ui/burger-menu', ['class' => 'text-primary mr-2 sm:hidden']); ?>
    </div>

    <?= component('web/ui/nav-menu', ['class' => 'xl:hidden']); ?>
</header>

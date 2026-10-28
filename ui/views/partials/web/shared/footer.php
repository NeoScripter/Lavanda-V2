<?php $hive = \Base::instance(); ?>

<footer>
    <?php if (!in_array(\Base::instance()->ALIAS, ['login', 'register', 'profile', 'plans_show'])) : ?>

        <nav class='bg-white shadow-accent rounded-3xl translate-y-12 px-8 lg:px-10 lg:py-12 py-10 mx-auto text-balance max-w-[min(calc(100%-var(--px-lg)*2),25rem)] lg:max-w-4/5'>
            <ol class='grid gap-8 lg:grid-cols-4 lg:gap-14 xl:[&_li,p]:text-lg '>
                <li>
                    <a href="/about" class='font-semibold text-[1.25em] text-primary'><?= $hive->get("web.о_ресурсе_") ?> </a>
                    <span class='h-1 bg-primary w-15 block my-4'></span>
                    <p><?= $hive->get("web._пространство_поддержки_и_вдохновения_здесь_вы_найдёте_простые_инструменты_которые_помогают_услышать_себя_") ?> </p>
                </li>
                <li>
                    <a href="/plans" class='font-semibold text-[1.25em] text-primary'><?= $hive->get("web.доступ_") ?>
                    </a>
                    <span class='h-1 bg-primary w-15 block my-4'></span>
                    <p><?= $hive->get("web.выберите_подходящий_тариф_поддержка_всегда_под_рукой_") ?> </p>
                </li>
                <li>
                    <a href="/contact" class='font-semibold text-[1.25em] text-primary'><?= $hive->get("web.контакты_") ?>
                    </a>
                    <span class='h-1 bg-primary w-15 block my-4'></span>
                    <p>
                        <?= $hive->get('web.остались_вопросы_напишите_авторам_будем_рады_обратной_связи_') ?>
                    </p>
                </li>
                <li>
                    <a href="/legal/privacy_policy" class='font-semibold text-[1.25em] text-primary'><?= $hive->get("web.оферта_") ?>
                    </a>
                    <span class='h-1 bg-primary w-15 block my-4'></span>
                    <p><?= $hive->get("web.здесь_можно_ознакомиться_с_условиями_использования_и_политиками_ресурса_") ?>
                    </p>
                </li>
            </ol>
        </nav>
    <?php endif; ?>
    <div class='px-(--px-lg) text-white bg-primary py-18 sm:py-20 lg:pt-24 rounded-t-2xl'>
        <div class='text-center sm:text-left space-y-[1.25em] lg:space-y-0 sm:pl-6'>
            <figure class='mx-auto w-45 sm:ml-0'>
                <img src="/assets/svgs/logo-lg-white.svg" class="size-full object-contain object-center" />
            </figure>
            <div class='sm:justify-start lg:justify-end justify-center w-full flex'>
                <a href="mailto:info@lavanda.kim"
                    class='[&>svg]:size-[1.25em] [&>svg]:stroke-1 hover:underline flex items-center gap-[0.5em]'
                    target="_blank">
                    <?= svg('mail') ?>
                    info@lavanda.kim</a>
            </div>
            <p>Lavanda.Kim <?= date('Y') ?><?= $hive->get("web._все_права_защищены_") ?>
            </p>
        </div>
    </div>
</footer>

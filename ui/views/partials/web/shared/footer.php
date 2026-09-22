<footer>
    <nav class='bg-white shadow-accent rounded-3xl translate-y-12 px-8 lg:px-10 lg:py-12 py-10 mx-auto text-balance max-w-[min(calc(100%-var(--padding-outer-lg)*2),25rem)] lg:max-w-4/5'>
        <ol class='grid gap-8 lg:grid-cols-4 lg:gap-14 xl:[&_li,p]:text-lg '>
            <li>
                <a href="" class='font-semibold text-[1.25em] text-primary'>О ресурсе</a>
                <span class='h-1 bg-primary w-15 block my-4'></span>
                <p>Lavanda.Kim — пространство поддержки и вдохновения. Здесь вы найдёте простые инструменты, которые помогают услышать себя.</p>
            </li>
            <li>
                <a href="" class='font-semibold text-[1.25em] text-primary'>Доступ</a>
                <span class='h-1 bg-primary w-15 block my-4'></span>
                <p>Выберите подходящий тариф. Поддержка всегда под рукой.</p>
            </li>
            <li>
                <a href="" class='font-semibold text-[1.25em] text-primary'>Контакты</a>
                <span class='h-1 bg-primary w-15 block my-4'></span>
                <p>Остались вопросы? Напишите авторам - будем рады обратной связи.</p>
            </li>
            <li>
                <a href="" class='font-semibold text-[1.25em] text-primary'>Оферта</a>
                <span class='h-1 bg-primary w-15 block my-4'></span>
                <p>Здесь можно ознакомиться с условиями использования и политиками ресурса.</p>
            </li>
        </ol>
    </nav>
    <div class='px-(--padding-outer-lg) text-white bg-primary py-18 sm:py-20 lg:pt-24 rounded-t-2xl'>
        <div class='text-center sm:text-left space-y-[1.25em] lg:space-y-0 sm:pl-6'>
            <figure class='mx-auto w-45 sm:ml-0'>
                <img src="/assets/svgs/logo-lg-white.svg" class="size-full object-contain object-center" />
            </figure>
            <a href="mailto:info@lavanda.kim"
                class='flex items-center gap-[0.5em] sm:justify-start lg:justify-end justify-center [&>svg]:size-[1.25em] [&>svg]:stroke-1 hover:underline'
                target="_blank">
                <?= svg('mail') ?>
                info@lavanda.kim</a>

            <p>Lavanda.Kim <?= date('Y') ?> © Все права защищены</p>
        </div>
    </div>
</footer>

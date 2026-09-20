<section>
    <h2>Как это устроено</h2>
    <p class='text-center text-balance'>Мы собрали способы, с помощью которых на протяжении тысячелетий искали ответы, принимали важные решения, просили совета и пытались заглянуть в будущее.</p>

    <ul class='grid gap-15 lg:gap-22 lg:grid-cols-2 xl:grid-cols-3 place-content-center mt-15 text-balance text-center lg:[&>li>article_h3]:text-3xl  [&>li>article]:max-w-110 lg:[&>li>article]:max-w-auto [&>li]:grid [&>li]:grid-rows-[min(20rem,80vw)_1fr]'>
        <li>
            <?= component('admin/ui/image', [
                'sizes'    => 'mb',
                'alt' => 'Stairs',
                'path'     => "/assets/images/pages/home/how_it_works/how_it_works_1",
                'prt_class' => 'mx-auto size-[min(90vw,22rem)]',
                'img_class' => 'size-full object-contain!',
            ]) ?>

            <article class='shadow-accent px-[1.5em] py-10 h-fit rounded-2xl mx-auto'>
                <div class='space-y-[0.75em]'>
                    <h3>Загляните</h3>
                    <p>Что привело вас в Lavanda?</p>
                    <p>В чем сегодня особенно нужна поддержка?</p>
                    <p class='font-bold text-primary'>Позвольте Lavanda первой заговорить с вами.</p>
                    <p>Начните с <u>Кошачьего оракула</u> - именно здесь многие с удивлением понимают, что привело их сегодня.</p>
                </div>

                <?= component('web/ui/button', [
                    'variant' => 'accent',
                    'slot' => 'Начать знакомство',
                    'class' => "mx-auto mt-[1.25em]"
                ]) ?>
            </article>

        </li>
        <li>
            <?= component('admin/ui/image', [
                'sizes'    => 'mb',
                'alt' => 'Stairs',
                'path'     => "/assets/images/pages/home/how_it_works/how_it_works_2",
                'prt_class' => 'mx-auto size-[min(90vw,22rem)]',
                'img_class' => 'size-full object-contain!',
            ]) ?>

            <article class='shadow-accent px-[1.5em] py-10 h-fit rounded-2xl mx-auto'>
                <div class='space-y-[0.75em]'>
                    <h3>Познакомьтесь</h3>
                    <p class='font-bold text-primary'>Исследуйте разные способы поддержки, бережно собранные и адаптированные авторами.</p>
                    <p>Древняя мудрость разных культур и эпох, современные практики и проверенные временем инструменты — всё, что помогало людям лучше понимать себя много веков назад и продолжает помогать сегодня.</p>
                    <p>Руны • Таро • Книга Перемен • тибетское МО • древние расклады на камнях • метафорические карты • «Игры разума» и многое другое</p>
                    <p class='font-bold text-primary'>Ваш вопрос. Ваше время. Ваш путь.</p>
                </div>

            </article>
        </li>
        <li class='lg:col-span-2 xl:col-span-1'>
            <?= component('admin/ui/image', [
                'sizes'    => 'mb',
                'alt' => 'Stairs',
                'path'     => "/assets/images/pages/home/how_it_works/how_it_works_3",
                'prt_class' => 'mx-auto size-[min(90vw,22rem)]',
                'img_class' => 'size-full object-contain!',
            ]) ?>

            <article class='shadow-accent px-[1.5em] py-10 h-fit rounded-2xl mx-auto'>
                <div class='space-y-[0.75em]'>
                    <h3>Возвращайтесь, если захочется</h3>
                    <p>Если почувствуете, что Lavanda стала для вас местом, куда хочется заглядывать снова, откройте всё пространство Lavanda или пользуйтесь только теми инструментами, которые стали вам особенно близки.</p>
                    <p>Без обязательств. Без скрытых условий. Всё — только по вашему желанию.</p>
                    <p class='font-bold text-primary'>В Lavanda всё происходит по любви — без давления, без спешки и с уважением к вашему выбору.</p>
                </div>
            </article>
        </li>
    </ul>
</section>

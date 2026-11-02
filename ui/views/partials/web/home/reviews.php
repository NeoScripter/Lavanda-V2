<?php $hive = \Base::instance(); ?>

<?php $reviews = [
    $hive->get("web.ни_разу_не_почувствовала_что_меня_учат_жить_именно_этого_и_хотелось_отдельное_спасибо"),
    $hive->get("web.не_думала_что_руны_могут_так_спокойно_разложить_всё_по_полочкам"),
    $hive->get("web.пришла_за_ответом_а_ушла_с_вопросом_который_мне_действительно_был_нужен"),
    $hive->get("web.персональный_разбор_стал_для_меня_лучшей_поддержкой_не_знаю_как_это_работает_но_всё_настолько_в_точку"),
    $hive->get("web.индивидуальная_поддержка_просто_в_самое_сердце_а_из_онлайн_практик_обожаю_книгу_перемен_она_какая-то_волшебная"),
    $hive->get("web.тибетские_кубики_мо_и_карты_с_кошками_теперь_мой_ритуал_перед_сном_смешно_и_почему_то_очень_точно"),
    $hive->get("web.кому_нужно_прям_до_деталей_идите_к_камням_в_мешочке_там_самое_подробное_всегда_есть_о_чём_подумать"),
    $hive->get("web.в_детстве_у_нас_откуда-то_были_карты_ленорман_и_я_часто_разглядывала_картинки_примеряя_их_к_жизни_так_обрадовалась_увидев_их_здесь"),
    $hive->get("web.огромное_спасибо_психологу_который_писал_комментарии_к_метафорическим_картам_для_меня_это_как_настоящая_терапия"),
]; ?>


<section cmp-reviews class='full-bleed isolate relative bg-primary-pale/50 py-(--spacing-y) px-(--px-lg) select-none visibility-auto'>

    <?= component('shared/ui/image', [
        'sizes'    => 'mb|tb|dk',
        'alt' => 'Golden stars',
        'path'     => '/assets/images/pages/home/reviews/stars',
        'prt_class' => 'h-full w-[calc(100%-(var(--px-lg)*2))] bg-contain! absolute! inset-y-0 inset-x-(--px-lg)',
        'img_class' => 'size-full object-contain!',
    ]) ?>

    <article class='max-w-209 mx-auto gap-6 flex items-center justify-center lg:gap-x-15'>
        <button cmp-prev-review class='rotate-180 z-10 transition-[transform,opacity] hidden sm:block disabled:opacity-50 hover:scale-105 cursor-pointer w-11 shrink-0'>
            <?= svg('carousel-btn') ?>
        </button>
        <div class='aspect-5/3 w-full max-w-150 xl:max-w-185 relative'>
            <?= component('shared/ui/image', [
                'sizes'    => 'mb|tb',
                'alt' => 'Open book with a violet crystal on the left page',
                'path'     => '/assets/images/pages/home/reviews/book',
                'prt_class' => 'size-full bg-contain!',
                'img_class' => 'size-full object-contain!',
            ]) ?>
            <div class='absolute right-[4.5em] top-[3em] bottom-[4em] text-[clamp(0.55rem,3vw,1rem)] md:text-lg left-[calc(50%+2em)] flex flex-col items-center justify-center'>
                <span aria-hidden="true" class='mr-auto absolute top-0 left-0 w-1/3 h-1/3'><?= svg('quotes') ?></span>
                <p cmp-current-review class='text-inherit transition-[transform,opacity] duration-500 ease-in-out relative z-1 text-balance'><?= $reviews[0] ?></p>
            </div>
        </div>
        <button cmp-next-review class='transition-transform z-10 hover:scale-105 disabled:opacity-50 hidden sm:block cursor-pointer w-11 shrink-0'>
            <?= svg('carousel-btn') ?>
        </button>
    </article>

    <div class='flex items-center justify-center gap-4.5 mt-6.5'>
        <button cmp-prev-review class='rotate-180 sm:hidden z-10 transition-[transform,opacity] disabled:opacity-50 hover:scale-105 cursor-pointer w-11 shrink-0'>
            <?= svg('carousel-btn') ?>
        </button>

        <ol class='flex gap-2 items-center justify-center z-10'>
            <?php foreach ($reviews as $idx => $review) : ?>
                <li>
                    <button type='button'
                        data-review="<?= $review ?>"
                        class="<?= 'rounded-full size-3 sm:size-4 transition-colors duration-500 ease-in-out cursor-pointer ' . ($idx === 0 ? 'bg-primary' : 'bg-gray-400') ?>"></button>
                </li>

            <?php endforeach; ?>
        </ol>

        <button cmp-next-review class='transition-[transform,opacity] z-10 sm:hidden disabled:opacity-50 hover:scale-105 cursor-pointer w-11 shrink-0'>
            <?= svg('carousel-btn') ?>
        </button>
    </div>

</section>

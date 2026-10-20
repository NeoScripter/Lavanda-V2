<section class='flex flex-col sm:flex-row gap-y-10 sm:justify-center sm:items-center xl:gap-10 visibility-auto'>
    <div class='sm:w-2/3 sm:max-w-160'>
        <h2 class='sm:text-left'>Почему вам понравится</h2>
        <ul class='*:bg-[url(/assets/svgs/golden-star.svg)] text-balance space-y-[1em] *:bg-no-repeat *:bg-position-[0%_0.25em] *:pl-[2em]'>
            <li>Здесь за текстом стоит живой человек и живой интеллект</li>
            <li>Это пространство для размышлений, а не категоричных предсказаний</li>
            <li>Тихий вечер, мягкая рефлексия и полная конфиденциальность — редкая ценность в современном мире</li>
            <li class='text-primary font-semibold bg-[url(/assets/svgs/violet-star.svg)]!'>А если захочется глубже — сделаем персональный разбор вашей ситуации</li>
        </ul>

    </div>

    <?= component('shared/ui/image', [
        'sizes'    => 'mb|tb',
        'alt' => 'Stairs',
        'path'     => '/assets/images/pages/home/why-it-helps/bracelet',
        'prt_class' => 'aspect-square max-w-80 w-full -order-1 lg:max-w-100 sm:order-0 sm:-mr-30 lg:mr-0',
        'img_class' => 'size-full object-contain!',
    ]) ?>

</section>

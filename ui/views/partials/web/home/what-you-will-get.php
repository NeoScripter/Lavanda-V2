<?php $hive = \Base::instance(); ?>
<?php $items = [
    [
        'img' => '/assets/images/pages/home/what-you-will-get/item-1',
        'alt' => 'sandclock',
        'title' => $hive->get("web.немного_тишины_в_голове"),
        'description' => $hive->get("web.и_немного_порядка_в_мыслях")
    ],
    [
        'img' => '/assets/images/pages/home/what-you-will-get/item-2',
        'alt' => 'eye',
        'title' => $hive->get("web.взгляд_со_стороны"),
        'description' => $hive->get("web.на_то_что_вы_возможно_уже_знаете_но_пока_успели_произнести_себе")
    ],
    [
        'img' => '/assets/images/pages/home/what-you-will-get/item-3',
        'alt' => 'crown',
        'title' => $hive->get("web.ощущение_я_справлюсь"),
        'description' => $hive->get("web.своё_настоящее")
    ],
]; ?>

<section class='full-bleed bg-primary-pale/50 py-(--spacing-y) px-(--px-lg) visibility-auto'>
    <h2><?= $hive->get("web.здесь_вы_получите") ?>
</h2>

    <ul class='grid justify-items-center place-content-center items-stretch sm:grid-cols-[repeat(2,17.625rem)] gap-x-15 lg:gap-x-25 2xl:gap-x-30 gap-y-10 lg:grid-cols-[repeat(3,17.625rem)]'>
        <?php foreach ($items as $item) : ?>

            <li class='max-w-70.5 w-full gap-y-[0.75em] sm:grid-rows-subgrid sm:row-span-3 grid justify-items-center last:sm:col-span-2 last:lg:col-span-1'>
                <?= component('shared/ui/image', [
                    'sizes'    => 'mb',
                    'alt' => $item['alt'],
                    'path'     => $item['img'],
                    'prt_class' => 'aspect-square w-26 lg:w-32 aspect-square bg-contain!',
                    'img_class' => 'size-full object-contain!',
                ]) ?>
                <h3 class='text-lg mb-0! sm:text-xl lg:text-2xl'><?= $item['title'] ?></h3>
                <p class='text-center text-balance'><?= $item['description'] ?></p>
            </li>
        <?php endforeach; ?>

    </ul>

</section>

<?php $items = [
    ['img' => '/assets/images/pages/home/what-you-will-get/item-1', 'alt' => 'sandclock', 'title' => qquila1Немного тишины в головеqquila2
, 'description' => qquila1и немного порядка в мысляхqquila2
],
    ['img' => '/assets/images/pages/home/what-you-will-get/item-2', 'alt' => 'eye', 'title' => qquila1Взгляд со стороныqquila2
, 'description' => qquila1на то, что вы, возможно, уже знаете, но пока успели произнести себеqquila2
],
    ['img' => '/assets/images/pages/home/what-you-will-get/item-3', 'alt' => 'crown', 'title' => qquila1Ощущение «я справлюсь»qquila2
, 'description' => qquila1Своё, настоящееqquila2
],
]; ?>

<section class='full-bleed bg-primary-pale/50 py-(--spacing-y) px-(--px-lg) visibility-auto'>
    <h2>Здесь вы получите</h2>

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

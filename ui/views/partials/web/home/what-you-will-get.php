<?php $items = [
    ['img' => '/assets/images/pages/home/what-you-will-get/item-1', 'alt' => 'sandclock', 'title' => 'Немного тишины в голове', 'description' => 'и немного порядка в мыслях'],
    ['img' => '/assets/images/pages/home/what-you-will-get/item-2', 'alt' => 'eye', 'title' => 'Взгляд со стороны', 'description' => 'на то, что вы, возможно, уже знаете, но пока успели произнести себе'],
    ['img' => '/assets/images/pages/home/what-you-will-get/item-3', 'alt' => 'crown', 'title' => "Ощущение «я справлюсь»", 'description' => 'Своё, настоящее'],
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

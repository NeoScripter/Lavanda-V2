<section class='flex flex-col sm:flex-row sm:justify-center sm:items-center xl:gap-10'>
    <div class='sm:w-2/3 sm:max-w-160'>
        <h2 class='sm:text-left'>Вам сюда, если</h2>
        <ul class='*:bg-[url(/assets/svgs/golden-star.svg)] text-balance space-y-[1em] *:bg-no-repeat *:bg-position-[0%_0.25em] *:pl-[2em]'>
            <li>Сомневаетесь и хочется разобраться прямо сейчас</li>
            <li>Важно услышать себя, а не чужие советы</li>
            <li>Хочется чего-то тёплого и персонального вместо бесконечного пустого скролла</li>
            <li>Или просто любопытно - это тоже отличная причина</li>
        </ul>

    </div>

    <?= component('shared/ui/image', [
        'sizes'    => 'mb|tb',
        'alt' => 'Stairs',
        'path'     => '/assets/images/pages/home/is-for-you/butterfly',
        'prt_class' => 'aspect-square max-w-100 w-full -order-1 lg:max-w-120 sm:order-0 sm:-mr-30 lg:mr-0',
        'img_class' => 'size-full object-contain!',
    ]) ?>

</section>

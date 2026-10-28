<?php $hive = \Base::instance() ;?>

<section class='flex flex-col sm:flex-row sm:justify-center sm:items-center xl:gap-10 visibility-auto'>
    <div class='sm:w-2/3 sm:max-w-160'>
        <h2 class='sm:text-left'><?= $hive->get("web.вам_сюда_если_") ?>
        </h2>
        <ul class='*:bg-[url(/assets/svgs/golden-star.svg)] text-balance space-y-[1em] *:bg-no-repeat *:bg-position-[0%_0.25em] *:pl-[2em]'>
            <li><?= $hive->get("web.сомневаетесь_и_хочется_разобраться_прямо_сейчас_") ?>
            </li>
            <li><?= $hive->get("web.важно_услышать_себя_а_не_чужие_советы_") ?>
            </li>
            <li><?= $hive->get("web.хочется_чегото_тёплого_и_персонального_вместо_бесконечного_пустого_скролла_") ?>
            </li>
            <li><?= $hive->get("web.или_просто_любопытно_это_тоже_отличная_причина_") ?>
            </li>
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

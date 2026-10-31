<?php

use Enums\PlanSlug;

$hive = \Base::instance(); ?>

<section class='flex flex-col sm:flex-row gap-y-10 sm:justify-center sm:items-center xl:gap-10 visibility-auto'>
    <div class='sm:w-2/3 sm:max-w-160'>
        <h2 class='sm:text-left'><?= $hive->get("web.почему_вам_понравится") ?>
        </h2>
        <ul class='*:bg-[url(/assets/svgs/golden-star.svg)] text-balance space-y-[1em] *:bg-no-repeat *:bg-position-[0%_0.25em] *:pl-[2em]'>
            <li><?= $hive->get("web.здесь_за_текстом_стоит_живой_человек_и_живой_интеллект") ?> </li>
            <li><?= $hive->get("web.это_пространство_для_размышлений_а_не_категоричных_предсказаний") ?> </li>
            <li><?= $hive->get("web.тихий_вечер_мягкая_рефлексия_и_полная_конфиденциальность_редкая_ценность_в_современном_мире") ?> </li>
            <li class='text-primary font-semibold bg-[url(/assets/svgs/violet-star.svg)]!'><?= $hive->get("web.а_если_захочется_глубже_сделаем") ?>
                <a href="<?= $hive->alias('plans_show', ['slug' => PlanSlug::PERSONAL->value]) ?>" class='underline underline-offset-4'>
                    <?= $hive->get('web.персональный_разбор_вашей_ситуации') ?>
                </a>
            </li>
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

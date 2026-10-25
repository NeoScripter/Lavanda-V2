<?php

use Enums\PlanSlug;
use Support\Auth;

extract(component_props(
    required: ['items'],
    optional: ['class' => ''],
    props: get_defined_vars()
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Тарифы',
    'class' => 'bg-white relative isolate',
]); ?>

<?php
$hive = \Base::instance();
$user = Auth::user();

$button_labels = [
    PlanSlug::YEARLY->value => 'Остаться на год',
    PlanSlug::MONTHLY->value => 'Остаться на месяц',
    PlanSlug::ONE_TIME->value => 'Получить ответы',
    PlanSlug::PERSONAL->value => 'Заказать разбор',
];
?>

<section class='pt-(--pt-lg)'>

    <h1>Выбери свой формат</h1>

    <p class='text-center text-balance'>Каждому — по душе и в своём ритме</p>

    <ul class='grid grid-cols-[repeat(auto-fit,minmax(min(100%,18.75rem),1fr))] justify-items-center gap-y-45 gap-x-10 mt-38 sm:mt-45 md:mt-50 lg:w-200 lg:mx-auto 2xl:mx-0 2xl:w-full '>
        <?php foreach ($items as $idx => $item) : ?>
            <?= component('web/ui/plan-card', [
                'item' => $item,
                'button' => component('web/ui/button', [
                    'variant' => $idx < 2 ? 'primary' : 'accent',
                    'slot' => $button_labels[$item['slug']],
                    'size' => 'md',
                    'href' => empty($user) ? $hive->alias('login') : $hive->alias('plans_show', ['slug' => $item['slug']]),
                ])
            ]) ?>
        <?php endforeach; ?>
    </ul>

</section>

<span class='absolute inset-0 bg-cover bg-no-repeat bg-center -z-1 size-full' style="background-image: url(/assets/images/shared/backgrounds/flowers/flowers-mb.webp);"></span>

<?php end_slot(); ?>

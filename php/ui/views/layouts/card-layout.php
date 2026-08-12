<?php

use Enums\CardVariant;
use Enums\SessionKey;

slot('layouts/admin-layout', compact('heading', 'title')); ?>

<?php
$hive = \Base::instance();
$path = $hive->PATH;

extract(component_props(
    required: ['heading'],
    optional: ['slot' => ''],
    props: get_defined_vars(),
));

$variant = $hive->get('SESSION.' . SessionKey::CARD_VARIANT->value);
$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);

$nav_items = [
    ['variant' => CardVariant::TAROT->value, 'title' => $hive->get('admin.tarot')],
    ['variant' => CardVariant::LENORMAND->value, 'title' => $hive->get('admin.lenormand')],
];

?>

<div class="px-4 py-6">
    <div class="flex flex-col space-y-8 xl:flex-row lg:space-y-0 lg:space-x-12">
        <aside class="w-full max-w-xl lg:w-48">
            <?= component('ui/heading', [
                'title'       => $hive->get('admin.cards'),
                'description' => $hive->get('admin.select_a_card_category'),
            ]) ?>

            <nav class="flex flex-col space-y-1 space-x-0">
                <?php foreach ($nav_items as $item): ?>
                    <?php slot('components/ui/auth-button', [
                        'size'    => 'sm',
                        'variant' => 'ghost',
                        'attrs'   => ['tabindex' => '-1'],
                        'class'   => 'relative w-full justify-start' . ($variant === $item['variant'] ? ' bg-muted' : ''),
                    ]); ?>
                    <a href="/admin/cards?variant=<?= $item['variant'] ?>" class="absolute inset-0 z-10"></a>
                    <?= $item['title'] ?>
                    <?php end_slot(); ?>
                <?php endforeach ?>
            </nav>
        </aside>

        <hr class="my-6 xl:hidden">

        <div class="flex-1">
            <section>
                <?= $slot ?>
            </section>
        </div>
    </div>
</div>

<?php end_slot(); ?>

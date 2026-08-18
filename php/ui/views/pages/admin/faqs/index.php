<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['cards', 'backside'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/card-grid-layout', [
    'heading' => $hive->get('admin.cards'),
    'title' => $hive->get('admin.cards')
]); ?>

<div class="space-y-12 w-[calc(100%-1rem)]">
    <nav class='flex flex-wrap w-full items-start gap-10 justify-between'>
        <?= component('ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm sm:order-2',
            'slot' => $hive->get('admin.create_new'),
            'href' => $hive->alias('admin_cards_create'),
        ]) ?>

        <?= component('ui/resource-locale-picker') ?>
    </nav>

    <?php if (! empty($cards['subset'])) : ?>
        <ul class="grid grid-cols-[repeat(auto-fill,minmax(10rem,1fr))] gap-12">

            <?php view('pages/admin/cards/partials/backside-editor', compact('backside')); ?>

            <?php foreach ($cards['subset'] as $card) : ?>
                <?php view('pages/admin/cards/partials/item', [
                    'card' => $card->to_resource(),
                ]); ?>
            <?php endforeach; ?>
        </ul>

        <?= component('ui/pagination', ['page' => $cards]) ?>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_cards_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>

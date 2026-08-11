<?php
$hive = \Base::instance();

extract(component_props(
    required: ['variant', 'locale', 'cards'],
    optional: [],
    props: get_defined_vars(),
));
?>

<?php slot('layouts/card-layout', [
    'heading' => $hive->get('admin.profile'),
    'title' => $hive->get('admin.profile'),
    'variant' => $variant,
    'locale' => $locale,
]); ?>

<div class="space-y-12 w-[calc(100%-1rem)]">
    <div class='flex flex-col sm:flex-row gap-6 items-start justify-between'>
        <?= component('ui/subheading', [
            'class'       => "[&>h3,&>p]:animate-none",
        ]) ?>

        <nav>
            <?= component('ui/auth-button', [
                'variant' => 'primary',
                'class'   => 'h-9 rounded-sm text-sm',
                'slot' => $hive->get('admin.create_new'),
                'href' => \Base::instance()->alias('admin_cards_create'),
            ]) ?>
        </nav>
    </div>

    <?php if (! empty($cards['subset'])) : ?>
        <ul class="grid grid-cols-[repeat(auto-fill,minmax(10rem,1fr))] gap-12">
            <?php foreach ($cards['subset'] as $card) : ?>
                <?php view('pages/admin/cards/partials/item', [
                    'card' => $card,
                ]); ?>
            <?php endforeach; ?>
        </ul>

        <?= component('ui/pagination', ['page' => $cards]) ?>
    <?php endif; ?>
</div>

<?php end_slot(); ?>

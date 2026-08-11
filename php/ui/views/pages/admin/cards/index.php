<?php $hive = \Base::instance(); ?>

<?php slot('layouts/card-layout', [
    'heading' => $hive->get('admin.profile'),
    'title' => $hive->get('admin.profile'),
]); ?>

<div class="space-y-6">
    <div>
        <?= component('ui/subheading', [
            'title' => "Cards",
            'description' => "Cards",
            'class'       => "[&>h3,&>p]:animate-none",
        ]) ?>

        <nav class="mb-2 mt-4">
            <?= component('ui/auth-button', [
                'variant' => 'primary',
                'class'   => 'h-9 rounded-sm text-sm',
                'slot' => 'Create New',
                'href' => \Base::instance()->alias('admin_cards_create'),
            ]) ?>
        </nav>
    </div>

    <?php if (! empty($cards['subset'])) : ?>
        <ul class="space-y-12">
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

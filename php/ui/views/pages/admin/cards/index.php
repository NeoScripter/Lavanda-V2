<?php

use Enums\Locale;

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
    <nav class='flex w-full items-start gap-6 justify-between'>
        <form method="GET" action="/admin/cards" class='grid gap-2'>
            <input type="hidden" name="variant" value="<?= $variant ?>" />
            <label for="locale-select"><?= $hive->get('admin.select_card_language') ?></label>
            <div>
                <select onchange="this.form.submit()" name="locale" class="cursor-pointer w-full" id="locale-select">
                    <?php foreach (Locale::labels() as $value => $label) : ?>
                        <option <?= $value === $locale ? 'selected' : '' ?> value="<?= $value ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
        <?= component('ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm',
            'slot' => $hive->get('admin.create_new'),
            'href' => \Base::instance()->alias('admin_cards_create'),
        ]) ?>
    </nav>

    <?php if (! empty($cards['subset'])) : ?>
        <ul class="grid grid-cols-[repeat(auto-fill,minmax(10rem,1fr))] gap-12">
            <?php foreach ($cards['subset'] as $card) : ?>
                <?php view('pages/admin/cards/partials/item', [
                    'card' => $card->to_resource(),
                ]); ?>
            <?php endforeach; ?>
        </ul>

        <?= component('ui/pagination', ['page' => $cards]) ?>
    <?php endif; ?>
</div>

<?php end_slot(); ?>

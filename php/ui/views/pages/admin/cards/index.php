<?php

use Enums\Locale;
use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/card-layout', [
    'heading' => $hive->get('admin.profile'),
    'title' => $hive->get('admin.profile'),
]); ?>

<div class="space-y-12 w-[calc(100%-1rem)]">
    <nav class='flex w-full items-start gap-6 justify-between'>
        <form method="POST" action="<?= $hive->alias('resource_locale') ?>" class='grid gap-2'>
            <?= csrf() ?>
            <input type="hidden" name="_method" value="PUT" />
            <label for="locale-select"><?= $hive->get('admin.select_card_language') ?></label>
            <div>
                <select onchange="this.form.submit()" name="<?= SessionKey::RESOURCE_LOCALE->value ?>" class="cursor-pointer w-full" id="locale-select">
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
            'href' => $hive->alias('admin_cards_create'),
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

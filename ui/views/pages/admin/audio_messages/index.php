<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['audios'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/admin/item-layout', [
    'heading' => $hive->get('admin.audios'),
    'title' => $hive->get('admin.audios')
]); ?>

<div class="space-y-8 w-[calc(100%-1rem)]">
    <nav class='flex flex-wrap w-full items-start gap-10 justify-between'>
        <?= component('admin/ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm sm:order-2',
            'slot' => $hive->get('admin.create_new'),
            'href' => $hive->alias('admin_audio_messages_create'),
        ]) ?>

        <?= component('admin/ui/resource-locale-picker') ?>
    </nav>

    <?php if (! empty($audios['subset'])) : ?>
        <ul class="grid gap-4">

            <?php foreach ($audios['subset'] as $audio) : ?>
                <?php view('pages/admin/audio_messages/partials/item', [
                    'audio' => $audio->cast(),
                ]); ?>
            <?php endforeach; ?>
        </ul>

        <?= component('admin/ui/pagination', ['page' => $audios]) ?>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_audios_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>

<?php

use Enums\CardVariant;

$hive = \Base::instance();

extract(component_props(
    required: ['title', 'heading', 'slot'],
    optional: [],
    props: get_defined_vars()
)); ?>
<?php slot('layouts/app-shell', compact('title')); ?>

<main
    class='text-sidebar-foreground bg-sidebar h-full min-h-svh text-sm md:flex md:items-start md:p-2' id="admin">
    <?= component('layout/sidebar', [
        'links' => [
            [
                'url'   => $hive->alias('dashboard'),
                'label' => $hive->get('admin.dashboard'),
                'icon'  => 'layout-grid',
            ],
            [
                'url'   => $hive->alias('admin_cards_index', []),
                'label' => $hive->get('admin.cards'),
                'icon'  => 'playing-cards',
            ],
            [
                'url'   => $hive->alias('admin_faqs_index'),
                'label' => 'FAQs',
                'icon'  => 'faq',
            ],
            [
                'url'   => $hive->alias('admin_runes_index'),
                'label' => $hive->get('admin.runes'),
                'icon'  => 'rune',
            ],
            [
                'url'   => $hive->alias('admin_ichings_index'),
                'label' => $hive->get('admin.iching'),
                'icon'  => 'iching',
            ],
            [
                'url'   => $hive->alias('admin_practice_items_index'),
                'label' => $hive->get('admin.practice'),
                'icon'  => 'practice',
            ],
            [
                'url'   => $hive->alias('admin_audio_messages_index'),
                'label' => $hive->get('admin.audios'),
                'icon'  => 'audio',
            ],
            [
                'url'   => $hive->alias('admin_affirmations_index'),
                'label' => $hive->get('admin.affirmations'),
                'icon'  => 'quote',
            ],
            [
                'url'   => $hive->alias('admin_articles_index'),
                'label' => $hive->get('admin.useful_resources'),
                'icon'  => 'newspaper',
            ],
            [
                'url'   => $hive->alias('admin_stones_index'),
                'label' => $hive->get('admin.stones'),
                'icon'  => 'stones',
            ],
        ],
    ]) ?>

    <div class="bg-background border-muted w-full border shadow-sm md:rounded-lg">
        <header
            class='border-muted flex items-center gap-3 border-b px-4 py-4'>
            <button
                data-open-sidebar-btn
                type='button'
                class="rounded-sm md:pointer-events-none">
                <?= svg('panel-left-icon') ?>
            </button>
            <span><?= $heading ?></span>
        </header>
        <div class='px-4 py-6'>
            <?= $slot ?? '' ?>
        </div>
    </div>
</main>

<?php end_slot(); ?>

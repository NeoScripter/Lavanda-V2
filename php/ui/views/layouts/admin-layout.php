<?php $hive = \Base::instance();

extract(component_props(
    required: ['title', 'heading', 'slot'],
    optional: [],
    props: get_defined_vars()
));?>
<?php slot('layouts/app-shell', compact('title')); ?>

<main
    class='text-sidebar-foreground bg-sidebar h-full min-h-svh text-sm md:flex md:items-start md:p-2' id="admin">
    <?= component('layout/sidebar', [
        'links' => [
            [
                'url'   => '/admin',
                'label' => $hive->get('admin.dashboard'),
                'icon'  => 'layout-grid',
            ],
            [
                'url'   => '/admin/cards',
                'label' => $hive->get('admin.cards'),
                'icon'  => 'playing-cards',
            ],
            [
                'url'   => '/admin/faqs',
                'label' => 'FAQs',
                'icon'  => 'faq',
            ],
            [
                'url'   => '/admin/runes',
                'label' => $hive->get('admin.runes'),
                'icon'  => 'rune',
            ],
            [
                'url'   => '/admin/ichings',
                'label' => $hive->get('admin.iching'),
                'icon'  => 'iching',
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
        <?= $slot ?? '' ?>
    </div>
</main>

<?php end_slot(); ?>

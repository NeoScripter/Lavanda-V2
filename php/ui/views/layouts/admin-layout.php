<?php $hive = \Base::instance() ;?>
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
            // [
            //     'url'   => '/admin/featured',
            //     'label' => 'Featured Section',
            //     'icon'  => 'feather',
            // ],
            // [
            //     'url'   => '/admin/news',
            //     'label' => 'Newsletters',
            //     'icon'  => 'mails',
            // ],
            // [
            //     'url'   => '/admin/articles',
            //     'label' => 'News Articles',
            //     'icon'  => 'newspaper',
            // ],
            // [
            //     'url'   => '/admin/programs',
            //     'label' => 'Programs',
            //     'icon'  => 'earth',
            // ],
            // [
            //     'url'   => '/admin/reports',
            //     'label' => 'Reports',
            //     'icon'  => 'file-stack',
            // ],
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
            <span><?= $heading ?? '' ?></span>
        </header>
        <?= $slot ?? '' ?>
    </div>
</main>

<?php end_slot(); ?>

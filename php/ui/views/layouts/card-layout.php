<?php slot('layouts/admin-layout', compact('heading', 'title')); ?>

<?php
$hive = \Base::instance();
$path = $hive->PATH;

extract(component_props(
    required: ['heading'],
    optional: ['slot' => ''],
    props: get_defined_vars(),
));

$nav_items = [
    ['title' => $hive->get('admin.tarot'), 'href' => '/admin/cards?category=tarot'],
    ['title' => $hive->get('admin.lenormand'),   'href' => '/admin/cards?category=lenormand'],
];

?>

<div class="px-4 py-6">
    <?= component('ui/heading', [
        'title'       => $hive->get('admin.cards'),
        'description' => $hive->get('admin.select_a_card_category'),
        'class'       => '[&>h2,&>p]:animate-none',
    ]) ?>

    <div class="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
        <aside class="w-full max-w-xl lg:w-48">
            <nav class="flex flex-col space-y-1 space-x-0">
                <?php foreach ($nav_items as $item): ?>
                    <?php slot('components/ui/auth-button', [
                        'size'    => 'sm',
                        'variant' => 'ghost',
                        'attrs'   => ['tabindex' => '-1'],
                        'class'   => 'relative w-full justify-start' . ($path === $item['href'] ? ' bg-muted' : ''),
                    ]); ?>
                    <a href="<?= $item['href'] ?>" class="absolute inset-0 z-10"></a>
                    <?= $item['title'] ?>
                    <?php end_slot(); ?>
                <?php endforeach ?>
            </nav>
        </aside>

        <hr class="my-6 xl:hidden">

        <div class="flex-1 md:max-w-2xl">
            <section class="max-w-xl space-y-12">
                <?= $slot ?>
            </section>
        </div>
    </div>
</div>

<?php end_slot(); ?>

<?php

extract(component_props(
    required: ['stone'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance(); ?>

<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.stones'),
    'title' => $hive->get('admin.stones')
]);

?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $stone['name']]) ?>

    <div class="space-y-10">
        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.stone_name') ?>
            </h3>
            <div>
                <?= $stone['name'] ?>
            </div>
        </div>

        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.stone_image') ?>
            </h3>
            <figure class="rounded-sm overflow-clip max-w-48 border border-border shadow-md aspect-2/3">
                <img class="size-full object-contain object-center"
                    src="<?= $stone['image']['src'] . "-tb.webp" ?>"
                    alt="<?= $stone['image']['src'] ?>">
            </figure>
        </div>

        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.stone_preview') ?>
            </h3>
            <figure class="rounded-sm overflow-clip max-w-48 border border-border shadow-md aspect-2/3">
                <img class="size-full object-contain object-center"
                    src="<?= $stone['preview']['src'] . "-mb.webp" ?>"
                    alt="<?= $stone['preview']['alt'] ?>">
            </figure>
        </div>

    </div>
    <div>
        <h3 class="my-6 font-medium">
            <?= $hive->get('admin.stone_meaning') ?>
        </h3>

        <div class="max-w-full prose prose-sm">
            <?= \Markdown::instance()->convert($stone['html']); ?>
        </div>
    </div>

    <?php end_slot(); ?>

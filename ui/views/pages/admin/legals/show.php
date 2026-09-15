<?php

extract(component_props(
    required: ['legal'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance(); ?>

<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.legals'),
    'title' => $hive->get('admin.legals')
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $hive->get('admin.legal')]) ?>

    <div class="space-y-6 max-w-160">
        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.legal_name') ?>
            </h3>
            <div>
                <?= $legal['name'] ?>
            </div>
        </div>

        <h3 class="mb-2 font-medium">
            <?= $hive->get('admin.preview') ?>
        </h3>
        <figure class="rounded-sm overflow-clip max-w-80 aspect-3/2">
            <img class="size-full object-cover object-center"
                src="<?= $legal?->preview?->src . "-tb.webp" ?>"
                alt="<?= $legal?->preview?->alt ?>">
        </figure>

        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.description') ?>
            </h3>
            <div>
                <?= $legal['description'] ?>
            </div>
        </div>

        <figure class="rounded-sm overflow-clip max-w-200 aspect-3/2">
            <img class="size-full object-cover object-center"
                src="<?= $legal?->image?->src . "-dk.webp" ?>"
                alt="<?= $legal?->image?->alt ?>">
        </figure>

        <div>
            <h3 class="my-15 font-medium">
                <?= $hive->get('admin.content') ?>
            </h3>
            <div class="max-w-full prose prose-sm">
                <?= \Markdown::instance()->convert($legal['html']); ?>
            </div>
        </div>
    </div>
</div>

<?php end_slot(); ?>

<?php

extract(component_props(
    required: ['article'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance(); ?>

<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.articles'),
    'title' => $hive->get('admin.articles')
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $hive->get('admin.article')]) ?>

    <div class="space-y-6 max-w-160">
        <figure class="rounded-sm overflow-clip max-w-80 border border-border shadow-md aspect-3/2">
            <img class="size-full object-cover object-center"
                src="<?= $article?->preview?->src . "-tb.webp" ?>"
                alt="<?= $article?->preview?->alt ?>">
        </figure>

        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.description') ?>
            </h3>
            <div>
                <?= $article['description'] ?>
            </div>
        </div>

        <figure class="rounded-sm overflow-clip max-w-200 border border-border shadow-md aspect-3/2">
            <img class="size-full object-cover object-center"
                src="<?= $article?->image?->src . "-dk.webp" ?>"
                alt="<?= $article?->image?->alt ?>">
        </figure>

        <div>
            <h3 class="my-15 font-medium">
                <?= $hive->get('admin.content') ?>
            </h3>
            <div class="max-w-full prose prose-sm">
                <?= \Markdown::instance()->convert($article['html']); ?>
            </div>
        </div>
    </div>
</div>

<?php end_slot(); ?>

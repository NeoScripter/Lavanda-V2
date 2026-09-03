<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['articles'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.articles'),
    'title' => $hive->get('admin.articles')
]); ?>

<div class="space-y-12 w-[calc(100%-1rem)]">
    <nav class='flex flex-wrap w-full items-start gap-10 justify-between'>
        <?= component('ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm sm:order-2',
            'slot' => $hive->get('admin.create_new'),
            'href' => $hive->alias('admin_articles_create'),
        ]) ?>

        <?= component('ui/resource-locale-picker') ?>
    </nav>

    <?php if (! empty($articles['subset'])) : ?>
        <ul class="grid grid-cols-[repeat(auto-fill,17rem)] gap-12">

            <?php foreach ($articles['subset'] as $article) : ?>
                <?php view('pages/admin/articles/partials/item', [
                    'article' => $article->to_resource(),
                ]); ?>
            <?php endforeach; ?>
        </ul>

        <?= component('ui/pagination', ['page' => $articles]) ?>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_articles_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>

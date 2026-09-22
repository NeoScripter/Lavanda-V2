<?php

extract(component_props(
    required: ['articles'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Полезные ресурсы',
    'class' => "bg-[url('/assets/images/pages/articles/articles-bg.webp')] bg-cover bg-center"
]); ?>

<!-- Hero Section -->
<?= partial('web/articles/hero') ?>

<!-- Articles -->
<section>
    <?php if (! empty($articles['subset'])) : ?>
        <ul class="grid [--sq-size:17.875rem] grid-cols-[repeat(auto-fill,min(100%,var(--sq-size)))] xl:grid-cols-4 justify-center gap-8">

            <?php foreach ($articles['subset'] as $article) : ?>
                <?= component('web/ui/article-card', [
                    'article' => $article->to_resource(),
                ]) ?>
            <?php endforeach; ?>
        </ul>

        <?= component('web/ui/pagination', ['page' => $articles]) ?>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_articles_here_yet') ?></p>
    <?php endif; ?>
</section>
<?php end_slot(); ?>

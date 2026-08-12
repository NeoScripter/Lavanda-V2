<?php slot('layouts/admin-layout', [
    'heading' => 'Articles',
    'title' => 'Articles'
]); ?>


<div class="space-y-6">
    <div class="admin-shell space-y-6">
        <div>
            <?= component('ui/subheading', [
                'title' => "Articles",
            ]) ?>

            <nav class="mb-2 mt-4">
                <?= component('ui/auth-button', [
                    'variant' => 'primary',
                    'class'   => 'h-9 rounded-sm text-sm',
                    'slot' => 'Create New',
                    'href' => \Base::instance()->alias('admin_articles_create'),
                ]) ?>
            </nav>
        </div>

        <?php if (! empty($articles['subset'])) : ?>
            <ul class="space-y-12">
                <?php foreach ($articles['subset'] as $article) : ?>
                    <?php view('pages/admin/articles/partials/item', [
                        'article' => $article,
                    ]); ?>
                <?php endforeach; ?>
            </ul>

            <?= component('ui/pagination', ['page' => $articles]) ?>
        <?php endif; ?>
    </div>
</div>

<?php end_slot(); ?>

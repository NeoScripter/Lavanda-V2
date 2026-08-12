<?php slot('layouts/admin-layout', [
    'heading' => 'Newsletters',
    'title' => 'Newsletters'
]); ?>


<div class="space-y-6">
    <div class="admin-shell space-y-6">
        <div>
            <?= component('ui/subheading', [
                'title' => "Newsletters",
            ]) ?>

            <nav class="mb-2 mt-4">
                <?= component('ui/auth-button', [
                    'variant' => 'primary',
                    'class'   => 'h-9 rounded-sm text-sm',
                    'slot' => 'Create New',
                    'href' => \Base::instance()->alias('admin_news_create'),
                ]) ?>
            </nav>
        </div>

        <?php if (! empty($news['subset'])) : ?>
            <ul class="space-y-12">
                <?php foreach ($news['subset'] as $article) : ?>
                    <?php view('pages/admin/news/partials/item', [
                        'article' => $article,
                    ]); ?>
                <?php endforeach; ?>
            </ul>

            <?= component('ui/pagination', ['page' => $news]) ?>
        <?php endif; ?>
    </div>
</div>

<?php end_slot(); ?>

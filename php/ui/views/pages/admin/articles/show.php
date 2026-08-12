<?php slot('layouts/admin-layout', [
    'heading' => 'Article',
    'title' => 'Article'
]); ?>

<?php $hive = \Base::instance(); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', [
            'title'       => 'Article',
        ]) ?>

        <div class="space-y-6 max-w-160">
            <div>
                <h3 class="mb-2 font-medium">Article title</h3>
                <div>
                    <?= $article['title'] ?>
                </div>
            </div>

            <figure class="aspect-square rounded-sm overflow-clip max-w-48">
                <img class="size-full object-cover object-center" src="<?= $article['image']['src'] .  "-mb.webp" ?>" alt="">
            </figure>

            <div>
                <h3 class="mb-2 font-medium">Article url</h3>
                <div>
                    <?= $article['url'] ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php end_slot(); ?>

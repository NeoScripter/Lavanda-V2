<?php slot('layouts/admin-layout', [
    'heading' => 'Newsletter',
    'title' => 'Newsletter'
]); ?>

<?php $hive = \Base::instance(); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', [
            'title'       => 'Newsletter',
        ]) ?>

        <div class="space-y-6 max-w-160">
            <div>
                <h3 class="mb-2 font-medium">Newsletter title</h3>
                <div>
                    <?= $article['title'] ?>
                </div>
            </div>

            <figure class="aspect-square rounded-sm overflow-clip max-w-48">
                <img class="size-full object-cover object-center" src="<?= $article['image']['src'] .  "-mb.webp" ?>" alt="">
            </figure>

            <div>
                <h3 class="mb-2 font-medium">Newsletter description</h3>
                <div>
                    <?= $article['summary'] ?>
                </div>
            </div>

            <div>
                <h3 class="mb-2 font-medium">Newsletter content</h3>
                <div class="max-w-full prose">
                    <?= html_entity_decode($article['body']) ?>
                </div>
            </div>
        </div>

        <?= component('ui/gallery', ['gallery' => $article->gallery, 'class' => 'mb-6']) ?>
    </div>
</div>

<?php end_slot(); ?>

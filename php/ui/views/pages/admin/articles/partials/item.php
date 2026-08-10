<?php $hive = \Base::instance(); ?>

<li class="grid max-w-140 gap-6 text-sm">
    <div class="flex flex-col gap-4">
        <p class="text-xs w-fit border border-muted-foreground rounded-sm py-1 px-2">
            <?= date_format(date_create($article->created_at), "j F Y") ?>
        </p>
        <?php if (isset($article->image)) : ?>
            <div class="relative w-fit">
                <?= component('ui/image', [
                    'sizes'    => 'mb',
                    'avif'    => false,
                    'path'     => $article->image->src,
                    'prt_class' => 'w-50 aspect-5/4 shrink-0 rounded-xl',
                ]) ?>
                <a href="<?= $hive->alias('admin_articles_show', ['id' => $article->id]) ?>" class="absolute inset-0 size-full block"></a>
            </div>
        <?php else : ?>
            <?= component('ui/image-skeleton') ?>
        <?php endif; ?>
        <h3 class="font-bold"><?= $article->title ?></h3>
    </div>

    <?= component('ui/item-actions', [
        'edit_url' => $hive->alias("admin_articles_edit", ['id' => $article->id]),
        'delete_url' => $hive->alias("admin_articles_destroy", ['id' => $article->id]),
        'item_label' => 'Article',
    ]) ?>
</li>

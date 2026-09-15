<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['article'],
    optional: [],
    props: get_defined_vars(),
));

$src = $article['preview']['src'] ?? to_public_url(WEBROOT . '/assets/images/shared/empty/empty');
?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-4">

        <div class="relative w-full">
            <?= component('ui/image', [
                'sizes'    => 'mb',
                'avif'    => false,
                'path'     => $src,
                'prt_class' => 'w-full shrink-0 rounded-xl aspect-3/2',
            ]) ?>
            <a href="<?= $hive->alias('admin_articles_show', ['id' => $article['id']]) ?>" class="absolute inset-0 size-full block"></a>
        </div>

        <p class="mb-2"><?= substr($article['description'], 0, 120) . '...' ?></p>

        <?= component('ui/item-actions', [
            'edit_url' => $hive->alias("admin_articles_edit", ['id' => $article['id']]),
            'delete_url' => $hive->alias("admin_articles_destroy", ['id' => $article['id']]),
            'item_label' => $hive->get('admin.article'),
        ]) ?>
    </div>

</li>

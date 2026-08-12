<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['card'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-4">

        <?php if (! empty($card['front_image']['src'])) : ?>
            <div class="relative w-full">
                <?= component('ui/image', [
                    'sizes'    => 'mb',
                    'avif'    => false,
                    'path'     => $card['front_image']['src'],
                    'prt_class' => 'w-full shrink-0 rounded-xl',
                ]) ?>
                <a href="<?= $hive->alias('admin_news_show', ['id' => $card['id']]) ?>" class="absolute inset-0 size-full block"></a>
            </div>
        <?php else : ?>
            <?= component('ui/image-skeleton') ?>
        <?php endif; ?>

        <div>
            <h3 class="mb-2 font-bold"><?= $card['name'] ?></h3>
        </div>

        <?= component('ui/item-actions', [
            'edit_url' => $hive->alias("admin_news_edit", ['id' => $card['id']]),
            'delete_url' => $hive->alias("admin_news_destroy", ['id' => $card['id']]),
            'item_label' => $hive->get('admin.card'),
        ]) ?>
    </div>

</li>

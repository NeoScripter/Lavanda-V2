<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['stone'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-4">

        <div class="relative w-full">
            <?= component('ui/image', [
                'sizes'    => 'mb',
                'avif'    => false,
                'path'     => $stone['preview']['src'],
                'img_class' => 'object-contain!',
                'prt_class' => 'w-full shrink-0 rounded-xl aspect-2/3 bg-contain!',
            ]) ?>
            <a href="<?= $hive->alias('admin_stones_show', ['id' => $stone['id']]) ?>" class="absolute inset-0 size-full block"></a>
        </div>

        <div>
            <h3 class="mb-2 font-bold"><?= $stone['name'] ?></h3>
        </div>

        <?= component('ui/item-actions', [
            'edit_url' => $hive->alias("admin_stones_edit", ['id' => $stone['id']]),
            'delete_url' => $hive->alias("admin_stones_destroy", ['id' => $stone['id']]),
            'item_label' => $hive->get('admin.stone'),
        ]) ?>
    </div>

</li>

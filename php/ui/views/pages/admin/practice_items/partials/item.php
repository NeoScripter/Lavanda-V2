<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['item'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-4">

        <div class="relative">
            <a href="<?= $hive->alias('admin_practice_items_show', ['id' => $item['id']]) ?>"
                class="absolute inset-0 size-full block"></a>
            <h3 class="mb-2 font-bold"><?= $item['title'] ?></h3>
            <p><?= $item['description'] ?></p>
        </div>

        <?= component('ui/item-actions-mini', [
            'edit_url' => $hive->alias("admin_practice_items_edit", ['id' => $item['id']]),
            'delete_url' => $hive->alias("admin_practice_items_destroy", ['id' => $item['id']]),
            'item_label' => $hive->get('admin.item'),
        ]) ?>
    </div>

</li>

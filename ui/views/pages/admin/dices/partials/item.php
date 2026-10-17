<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['dice'],
    optional: ['idx' => 1],
    props: get_defined_vars(),
));

$dices = require(APP_DIR . '/ui/data/models/dices.php'); ?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-4">

        <div class='relative w-fit'>
            <h4 class='font-medium mb-2'><?= $hive->get('admin.dice') . " $idx" ?></h4>

            <ul class='flex gap-3'>
                <?php foreach (explode('|', $dice['diceable_id']) as $id) : ?>
                    <?php $item = array_find($dices, fn($dice) => $dice['id'] === (int) $id); ?>
                    <li class="relative w-30">
                        <?= component('shared/ui/image', [
                            'sizes'    => 'mb',
                            'path'     => $item['image'],
                            'prt_class' => 'w-full shrink-0 rounded-xl aspect-square bg-contain!',
                            'img_class' => 'object-contain!',
                        ]) ?>
                        <p class='uppercase text-center text-xl font-bold mt-2'><?= $item['name'] ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="<?= $hive->alias('admin_dices_show', ['id' => $dice['id']]) ?>" class="absolute inset-0 size-full block"></a>
        </div>

        <?= component('admin/ui/item-actions-mini', [
            'edit_url' => $hive->alias("admin_dices_edit", ['id' => $dice['id']]),
            'delete_url' => $hive->alias("admin_dices_destroy", ['id' => $dice['id']]),
            'item_label' => $hive->get('admin.dice'),
        ]) ?>
    </div>

</li>

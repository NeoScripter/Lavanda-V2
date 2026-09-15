<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['match_set'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-4">

        <div class='relative'>
            <h4 class='font-medium mb-2'><?= $hive->get('admin.match_set') ?></h4>

            <ul class='grid grid-cols-[repeat(auto-fill,2rem)] xs:grid-cols-[repeat(auto-fill,4rem)]'>
                <?php foreach ($match_set['images'] as $img) : ?>
                    <li class="relative w-40">
                        <?= component('ui/image', [
                            'sizes'    => 'mb',
                            'avif'    => false,
                            'path'     => $img['src'],
                            'prt_class' => 'w-full shrink-0 rounded-xl aspect-2/3 bg-contain!',
                            'img_class' => 'object-contain!',
                        ]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="<?= $hive->alias('admin_match_sets_show', ['id' => $match_set['id']]) ?>" class="absolute inset-0 size-full block"></a>
        </div>

        <?= component('ui/item-actions-mini', [
            'edit_url' => $hive->alias("admin_match_sets_edit", ['id' => $match_set['id']]),
            'delete_url' => $hive->alias("admin_match_sets_destroy", ['id' => $match_set['id']]),
            'item_label' => $hive->get('admin.match_set'),
        ]) ?>
    </div>

</li>

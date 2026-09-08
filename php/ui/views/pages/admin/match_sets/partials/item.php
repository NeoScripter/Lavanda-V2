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
            <ul>
                <?php foreach ($match_set['images'] as $img) : ?>
                    <div class="relative w-full">
                        <?= component('ui/image', [
                            'sizes'    => 'mb',
                            'avif'    => false,
                            'path'     => $img['src'],
                            'prt_class' => 'w-full shrink-0 rounded-xl aspect-2/3 bg-contain!',
                            'image_class' => 'object-contain!',
                        ]) ?>
                    </div>
                <?php endforeach; ?>
            </ul>
            <a href="<?= $hive->alias('admin_match_sets_show', ['id' => $match_set['id']]) ?>" class="absolute inset-0 size-full block"></a>
        </div>

        <?= component('ui/item-actions', [
            'edit_url' => $hive->alias("admin_match_sets_edit", ['id' => $match_set['id']]),
            'delete_url' => $hive->alias("admin_match_sets_destroy", ['id' => $match_set['id']]),
            'item_label' => $hive->get('admin.match_set'),
        ]) ?>
    </div>

</li>

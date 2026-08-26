<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['rune'],
    optional: [],
    props: get_defined_vars(),
));

$src = $rune['front_image']['src'] ?? to_public_url(WEBROOT . '/assets/images/shared/empty/empty');
?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-4">

        <div class="relative w-full">
            <?= component('ui/image', [
                'sizes'    => 'mb',
                'avif'    => false,
                'path'     => $src,
                'prt_class' => 'w-full shrink-0 rounded-xl aspect-2/3',
            ]) ?>
            <a href="<?= $hive->alias('admin_runes_show', ['id' => $rune['id']]) ?>" class="absolute inset-0 size-full block"></a>
        </div>

        <div>
            <h3 class="mb-2 font-bold"><?= $rune['name'] ?></h3>
        </div>

        <?= component('ui/item-actions', [
            'edit_url' => $hive->alias("admin_runes_edit", ['id' => $rune['id']]),
            'delete_url' => $hive->alias("admin_runes_destroy", ['id' => $rune['id']]),
            'item_label' => $hive->get('admin.rune'),
        ]) ?>
    </div>

</li>

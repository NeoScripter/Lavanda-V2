<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['card'],
    optional: [],
    props: get_defined_vars(),
));

$src = $card['front_image']['src'] ?? to_public_url(WEBROOT . '/assets/images/shared/empty/empty');
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
            <a href="<?= $hive->alias('admin_cards_show', ['id' => $card['id']]) ?>" class="absolute inset-0 size-full block"></a>
        </div>

        <div>
            <h3 class="mb-2 font-bold"><?= $card['name'] ?></h3>
        </div>

        <?= component('ui/item-actions', [
            'edit_url' => $hive->alias("admin_cards_edit", ['id' => $card['id']]),
            'delete_url' => $hive->alias("admin_cards_destroy", ['id' => $card['id']]),
            'item_label' => $hive->get('admin.card'),
        ]) ?>
    </div>

</li>

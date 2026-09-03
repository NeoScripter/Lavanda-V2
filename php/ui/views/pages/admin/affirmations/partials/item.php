<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['affirmation'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-3">
        <div>
            <h3 class="mb-2 font-bold"><?= $affirmation->quote ?></h3>
        </div>
        <?= component('ui/item-actions-mini', [
            'edit_url' => $hive->alias("admin_affirmations_edit", ['id' => $affirmation->id]),
            'delete_url' => $hive->alias("admin_affirmations_destroy", ['id' => $affirmation->id]),
            'item_label' => $hive->get('admin.affirmation'),
        ]) ?>

    </div>
</li>

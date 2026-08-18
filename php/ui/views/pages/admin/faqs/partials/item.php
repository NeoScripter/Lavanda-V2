<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['faq'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-4">

        <div class="relative w-full">
            <a href="<?= $hive->alias('admin_faqs_show', ['id' => $faq->id]) ?>" class="absolute inset-0 size-full block"></a>
        </div>

        <div>
            <h3 class="mb-2 font-bold"><?= $faq->question ?></h3>
        </div>

        <?= component('ui/item-actions', [
            'edit_url' => $hive->alias("admin_faqs_edit", ['id' => $faq->id]),
            'delete_url' => $hive->alias("admin_faqs_destroy", ['id' => $faq->id]),
            'item_label' => $hive->get('admin.faq'),
        ]) ?>
    </div>

</li>

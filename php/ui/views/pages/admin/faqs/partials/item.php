<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['faq'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-3">
        <div>
            <h3 class="mb-2 font-bold"><?= $faq->question ?></h3>
            <p><?= $faq->answer ?></p>
        </div>
        <?= component('ui/item-actions-mini', [
            'edit_url' => $hive->alias("admin_faqs_edit", ['id' => $faq->id]),
            'delete_url' => $hive->alias("admin_faqs_destroy", ['id' => $faq->id]),
            'item_label' => $hive->get('admin.faq'),
        ]) ?>

    </div>
</li>

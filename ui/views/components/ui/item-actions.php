<?php
$modal_id = uniqid('modal_');
$hive = \Base::instance();
extract(component_props(
    required: ['delete_url', 'item_label'],
    optional: ['edit_url' => null],
    props: get_defined_vars(),
));; ?>

<div class='flex flex-col gap-2'>

    <?php if (isset($edit_url)) : ?>
        <?= component('ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm',
            'slot' => $hive->get('admin.edit'),
            'href' => $edit_url,
        ]) ?>
    <?php endif; ?>

    <?= component('ui/auth-button', [
        'variant' => 'destructive',
        'class'   => 'rounded-sm',
        'slot' => $hive->get('admin.delete'),
        'attrs' => [
            'component-modal-show' => true,
            'data-modal-id' => $modal_id,
            'type' => 'button',
        ]
    ]) ?>

    <?= component('ui/delete-confirmation-modal', [
        'delete_url' => $delete_url,
        'modal_id'   => $modal_id,
        'item_name'   => $item_label,
        'class'   => 'rounded-sm',
    ]) ?>
</div>

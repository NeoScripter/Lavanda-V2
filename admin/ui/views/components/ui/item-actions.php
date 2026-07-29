<?php $modal_id = uniqid('modal_'); ?>

<div class='flex items-center gap-2'>

    <?php if (isset($edit_url)) : ?>
        <?= component('ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm',
            'slot' => 'Edit',
            'href' => $edit_url,
        ]) ?>
    <?php endif; ?>

    <?= component('ui/auth-button', [
        'variant' => 'destructive',
        'class'   => 'rounded-sm',
        'slot' => 'Delete',
        'type' => 'submit',
        'attrs' => [
            'component-modal-show' => true,
            'data-modal-id' => $modal_id
        ]
    ]) ?>

    <?= component('ui/delete-confirmation-modal', [
        'delete_url' => $delete_url,
        'modal_id'   => $modal_id,
        'item_name'   => $item_label,
        'class'   => 'rounded-sm',
    ]) ?>
</div>

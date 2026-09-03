<?php
$modal_id = uniqid('modal_');
$hive = \Base::instance();
extract(component_props(
    required: ['delete_url', 'item_label'],
    optional: ['edit_url' => null],
    props: get_defined_vars(),
));; ?>

<div class='flex items-start gap-2'>

    <?php if (! empty($edit_url)) : ?>
        <a
            href="<?= $edit_url ?>"
            class="size-8 flex items-center justify-center transition-[border,opacity] border border-transparent hover:opacity-80 hover:border-current rounded-sm">
            <span class="size-2/3 flex items-center justify-center">
                <?= svg('pencil') ?>
            </span>
        </a>
    <?php endif; ?>

    <button
        component-modal-show
        data-modal-id="<?= $modal_id ?>"
        class="size-8 rounded-sm transition-colors border border-destructive hover:bg-destructive/90 bg-destructive flex items-center justify-center">
        <span class="size-2/3 text-white flex items-center justify-center">
            <?= svg('trash') ?>
        </span>
    </button>

    <?= component('ui/delete-confirmation-modal', [
        'delete_url' => $delete_url,
        'modal_id'   => $modal_id,
        'item_name'   => $item_label,
        'class'   => 'rounded-sm',
    ]) ?>
</div>

<?php

$item_name = $item_name ?? '';
$class = $class ?? '';

$final_class = trim('grid gap-6 max-w-9/10  sm:max-w-100 lg:max-w-160 w-full' . $class);
?>
<?php slot('components/layout/modal', ['modal_id' => $modal_id]); ?>

<div class="<?= $final_class ?>">
    <div class="space-y-2">
        <h2 class="text-2xl font-semibold">Delete <?= $item_name ?></h2>
        <p class="text-muted-foreground">
            Are you sure you want to delete this <?= strtolower($item_name) ?>? This action cannot be undone.
        </p>
    </div>
    <div class="flex items-center justify-end gap-4">
        <form action="<?= $delete_url ?>" method="post">
            <input type="hidden" name="_method" value="delete">
            <?= csrf() ?>

            <?= component('ui/auth-button', [
                'variant' => 'destructive',
                'size'    => 'lg',
                'class'   => 'w-fit text-base',
                'slot'   => 'Delete',
                'attrs'   => ['type' => 'submit'],
            ]) ?>
        </form>

        <?= component('ui/auth-button', [
            'variant' => 'default',
            'size'    => 'lg',
            'class'   => 'w-fit text-base',
            'slot' => 'Cancel',
            'attrs'   => [
                'type'    => 'button',
                'component-modal-dismiss' => true
            ]
        ]) ?>
    </div>
</div>

<?php end_slot(); ?>

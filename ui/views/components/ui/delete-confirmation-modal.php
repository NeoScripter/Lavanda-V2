<?php

$hive = \Base::instance();

extract(component_props(
    required: ['modal_id', 'delete_url'],
    optional: ['class' => ''],
    props: get_defined_vars(),
));

$final_class = trim('grid gap-6 max-w-9/10  sm:max-w-100 lg:max-w-160 w-full' . $class);
?>
<?php slot('components/layout/modal', ['modal_id' => $modal_id]); ?>

<div class="<?= $final_class ?>">
    <div class="space-y-2">
        <h2 class="text-2xl font-semibold"> <?= $hive->get('admin.delete_element') ?></h2>
        <p class="text-muted-foreground">
            <?= $hive->get('admin.are_you_sure_you_want_to_delete_this_element_this_action_cannot_be_undone') ?>
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
                'slot'   => $hive->get('admin.delete'),
                'attrs'   => ['type' => 'submit'],
            ]) ?>
        </form>

        <?= component('ui/auth-button', [
            'variant' => 'default',
            'size'    => 'lg',
            'class'   => 'w-fit text-base',
            'slot' => $hive->get('admin.cancel'),
            'attrs'   => [
                'type'    => 'button',
                'component-modal-dismiss' => true
            ]
        ]) ?>
    </div>
</div>

<?php end_slot(); ?>

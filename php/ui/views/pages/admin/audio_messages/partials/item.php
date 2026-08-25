<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['audio'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm">
    <div class="flex flex-col gap-4">

        <div class="relative">
            <a href="<?= $hive->alias('admin_audio_messages_show', ['id' => $audio['_id']]) ?>"
                class="absolute inset-0 size-full block"></a>

            <p><?= $audio['description'] ?></p>
        </div>

        <?= component('ui/item-actions-mini', [
            'edit_url' => $hive->alias("admin_audio_messages_edit", ['id' => $audio['_id']]),
            'delete_url' => $hive->alias("admin_audio_messages_destroy", ['id' => $audio['_id']]),
            'item_label' => $hive->get('admin.audio'),
        ]) ?>
    </div>

</li>

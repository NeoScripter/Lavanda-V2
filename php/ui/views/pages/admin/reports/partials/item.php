<?php $hive = \Base::instance(); ?>
<?php $uid = "report_{$report->id}"; ?>

<li 
    id="<?= $uid ?>" 
    component-draggable-report
    class="max-w-140 border border-accent-background rounded-sm transition-[scale,box-shadow] ease-in-out duration-200" draggable="true">
    <template>
        <form action="<?= $hive->alias('admin_reports_reorder') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="put">
            <input type="hidden" name="dragged_id">
            <input type="hidden" name="target_id">
            <?= csrf() ?>
        </form>
    </template>
    <div class="relative shadow-md py-2 px-4 rounded-sm flex items-center flex-wrap gap-4 justify-between">
        <h3 class="font-medium text-base min-w-50"><?= $report->title ?></h3>

        <?= component('ui/item-actions', [
            'delete_url' => $hive->alias("admin_reports_destroy", ['id' => $report->id]),
            'edit_url' => $hive->alias("admin_reports_edit", ['id' => $report->id]),
            'item_label' => 'Report',
        ]) ?>
    </div>
</li>

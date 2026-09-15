<?php $hive = \Base::instance(); ?>
<?php slot('layouts/admin-layout', [
    'heading' => $hive->get('admin.dashboard'),
    'title' => $hive->get('admin.dashboard')
]); ?>

<div
    class='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
    <div><?= $hive->get('admin.this_is_the_dashboard_page') ?></div>
</div>

<?php end_slot(); ?>

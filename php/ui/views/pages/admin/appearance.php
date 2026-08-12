<?php $hive = \Base::instance(); ?>
<?php slot('layouts/profile-layout', [
    'heading' => $hive->get('admin.appearance'),
    'title' => $hive->get('admin.appearance')
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', [
        'title'       => $hive->get('admin.appearance_settings'),
        'description' => $hive->get("admin.update_your_account_theme"),
    ]) ?>

    <?= component('ui/appearance-tabs') ?>
</div>

<?php end_slot(); ?>

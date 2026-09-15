<?php $hive = \Base::instance(); ?>
<?php slot('layouts/admin/profile-layout', [
    'heading' => $hive->get('admin.appearance'),
    'title' => $hive->get('admin.appearance')
]); ?>

<div class="space-y-6">
    <?= component('admin/ui/subheading', [
        'title'       => $hive->get('admin.language_settings'),
        'description' => $hive->get("admin.change_your_account_locale"),
    ]) ?>

    <?= component('admin/ui/locale-tabs') ?>
</div>

<?php end_slot(); ?>

<?php $hive = \Base::instance(); ?>
<?php slot('layouts/profile-layout', [
    'heading' => $hive->get('admin.appearance'),
    'title' => $hive->get('admin.appearance')
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', [
        'title'       => $hive->get('admin.language_settings'),
        'description' => $hive->get("admin.change_your_account_locale"),
    ]) ?>

    <?= component('ui/locale-tabs') ?>
</div>

<?php end_slot(); ?>

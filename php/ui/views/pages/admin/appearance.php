<?php $hive = \Base::instance(); ?>
<?php slot('layouts/profile-layout', [
    'heading' => $hive->get('admin.appearance'),
    'title' => $hive->get('admin.appearance')
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', [
        'title'       => 'Appearance settings',
        'description' => "Update your account's theme",
        'class'       => "[&>h3,&>p]:animate-none",
    ]) ?>

    <?= component('ui/appearance-tabs') ?>
</div>

<?php end_slot(); ?>

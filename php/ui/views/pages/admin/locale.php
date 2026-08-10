<?php $hive = \Base::instance(); ?>
<?php slot('layouts/profile-layout', [
    'heading' => $hive->get('admin.appearance'),
    'title' => $hive->get('admin.appearance')
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', [
        'title'       => 'Language settings',
        'description' => "Change your account's locale",
        'class'       => "[&>h3,&>p]:animate-none",
    ]) ?>

    <?= component('ui/locale-tabs') ?>
</div>

<?php end_slot(); ?>

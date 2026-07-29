<?php slot('layouts/profile-layout', [
    'heading' => 'Appearance',
    'title' => 'Appearance'
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', [
        'title'       => 'Appearance settings',
        'description' => "Update your account's theme",
        'class'       => "[&>h3,&>p]:animate-none",
    ]) ?>

    <?= component('ui/appearance-tabs', [
        'name'  => 'name',
        'label' => 'Full name',
        'error' => $errors['name'] ?? '',
        'attrs' => [
            'type'     => 'text',
            'required' => true,
            'value'    => $values['name'] ?? '',
        ],
    ]) ?>
</div>

<?php end_slot(); ?>

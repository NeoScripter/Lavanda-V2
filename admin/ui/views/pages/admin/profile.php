<?php slot('layouts/profile-layout', [
    'heading' => 'Profile',
    'title' => 'Profile',
]); ?>

<div class="space-y-6">
    <?= component('ui/subheading', [
        'title'       => 'Profile information',
        'description' => 'Update your name and email address',
        'class'       => "[&>h3,&>p]:animate-none",
    ]) ?>

    <form action="<?= \Base::instance()->alias('profile_update') ?>" method="post" class="space-y-6">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'name',
            'label' => 'Full name',
            'error' => $errors['name'] ?? '',
            'attrs' => [
                'type'     => 'text',
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-input', [
            'name'  => 'email',
            'label' => 'Email Address',
            'error' => $errors['email'] ?? '',
            'attrs' => [
                'type'     => 'email',
                'required' => true,
            ],
        ]) ?>

        <div class="flex justify-between gap-2.5">
            <?php slot('components/ui/auth-button', ['attrs' => ['type' => 'submit']]); ?>
            Save
            <?php end_slot(); ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

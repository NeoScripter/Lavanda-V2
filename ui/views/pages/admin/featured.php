<?php slot('layouts/admin/app-layout', [
    'heading' => 'Featured',
    'title' => 'Featured'
]); ?>

<div class="space-y-6">

    <?= component('admin/ui/subheading', [
        'title'       => 'Featured Section',
        'description' => 'Update the featured section on the home page',
    ]) ?>

    <form action="<?= \Base::instance()->alias('featured_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <?= csrf() ?>

        <?= component('admin/form/form-input', [
            'name'  => 'title',
            'label' => 'Section title',
            'attrs' => [
                'type'     => 'text',
                'required' => true,
                'value'    => $feat['title'],
            ],
        ]) ?>

        <?= component('admin/form/form-file-input', [
            'name'  => 'image',
            'label' => 'Preview Image',
            'value'    => [$feat['image'] ?? null],
            'with_alt' => true,
            'attrs' => [
                'required' => false,
                'multiple' => false,
            ],
        ]) ?>

        <?= component('admin/form/form-textarea', [
            'name'  => 'subtitle',
            'label' => 'Section subtitle',
            'attrs' => [
                'required' => true,
                'value'    => $feat['subtitle'],
            ],
        ]) ?>

        <?= component('admin/form/checkbox', [
            'label' => 'Show on the page',
            'name'  => 'shown',
            'attrs' => [
                'checked'    => $feat['shown'] ?? false,
            ],
        ]) ?>

        <?= component('admin/form/form-wysiwyg', [
            'name'  => 'body',
            'label' => 'Section content',
            'attrs' => [
                'required' => true,
                'value'    => $feat['body'],
            ],
        ]) ?>

        <div class="flex justify-between gap-2.5">
            <?php slot('components/admin/ui/auth-button', ['attrs' => ['type' => 'submit']]); ?>
            Save
            <?php end_slot(); ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

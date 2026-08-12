<?php slot('layouts/admin-layout', [
    'heading' => 'Featured',
    'title' => 'Featured'
]); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', [
            'title'       => 'Featured Section',
            'description' => 'Update the featured section on the home page',
        ]) ?>

        <form action="<?= \Base::instance()->alias('featured_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <?= csrf() ?>

            <?= component('form/form-input', [
                'name'  => 'title',
                'label' => 'Section title',
                'attrs' => [
                    'type'     => 'text',
                    'required' => true,
                    'value'    => $feat['title'],
                ],
            ]) ?>

            <?= component('form/form-file-input', [
                'name'  => 'image',
                'label' => 'Preview Image',
                'value'    => [$feat['image'] ?? null],
                'with_alt' => true,
                'attrs' => [
                    'required' => false,
                    'multiple' => false,
                ],
            ]) ?>

            <?= component('form/form-textarea', [
                'name'  => 'subtitle',
                'label' => 'Section subtitle',
                'attrs' => [
                    'required' => true,
                    'value'    => $feat['subtitle'],
                ],
            ]) ?>

            <?= component('form/checkbox', [
                'label' => 'Show on the page',
                'name'  => 'shown',
                'attrs' => [
                    'checked'    => $feat['shown'] ?? false,
                ],
            ]) ?>

            <?= component('form/form-wysiwyg', [
                'name'  => 'body',
                'label' => 'Section content',
                'attrs' => [
                    'required' => true,
                    'value'    => $feat['body'],
                ],
            ]) ?>

            <div class="flex justify-between gap-2.5">
                <?php slot('components/ui/auth-button', ['attrs' => ['type' => 'submit']]); ?>
                Save
                <?php end_slot(); ?>
            </div>
        </form>
    </div>
</div>

<?php end_slot(); ?>

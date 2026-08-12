<?php slot('layouts/admin-layout', [
    'heading' => 'Newsletter',
    'title' => 'Newsletter'
]); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', [
            'title'       => 'Create a newsletter',
        ]) ?>

        <form action="<?= \Base::instance()->alias('admin_news_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <?= csrf() ?>

            <?= component('form/form-input', [
                'name'  => 'title',
                'label' => 'Newsletter title',
                'attrs' => [
                    'type'     => 'text',
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-input', [
                'name'  => 'created_at',
                'label' => 'Date',
                'attrs' => [
                    'type'     => 'date',
                    'value'    => date('Y-m-d'),
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-file-input', [
                'name'  => 'preview',
                'label' => 'Image',
                'with_alt' => true,
                'attrs' => [
                    'required' => true,
                    'multiple' => false,
                ],
            ]) ?>

            <?= component('form/form-textarea', [
                'name'  => 'summary',
                'label' => 'Newsletter description',
                'attrs' => [
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-wysiwyg', [
                'name'  => 'body',
                'label' => 'Newsletter content',
                'attrs' => [
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-file-input', [
                'name'  => 'gallery',
                'label' => 'Gallery Images',
                'value'    => $article['gallery'] ?? [],
                'with_alt' => true,
                'attrs' => [
                    'required' => false,
                    'multiple' => true,
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

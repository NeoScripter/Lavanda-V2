<?php slot('layouts/admin-layout', [
    'heading' => 'Article',
    'title' => 'Article'
]); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', [
            'title'       => 'Create an article',
            'class'       => "[&>h3,&>p]:animate-none",
        ]) ?>

        <form action="<?= \Base::instance()->alias('admin_articles_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <?= csrf() ?>

            <?= component('form/form-input', [
                'name'  => 'title',
                'label' => 'Article title',
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

            <?= component('form/form-input', [
                'name'  => 'url',
                'label' => 'Article url',
                'attrs' => [
                    'type'     => 'text',
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

            <div class="flex justify-between gap-2.5">
                <?php slot('components/ui/auth-button', ['attrs' => ['type' => 'submit']]); ?>
                Save
                <?php end_slot(); ?>
            </div>
        </form>
    </div>
</div>

<?php end_slot(); ?>

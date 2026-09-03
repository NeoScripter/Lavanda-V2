<?php

$hive = \Base::instance();

slot('layouts/item-layout', [
    'heading' => $hive->get('admin.articles'),
    'title' => $hive->get('admin.articles'),
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $hive->get('admin.create_article')]) ?>

    <form action="<?= \Base::instance()->alias('admin_articles_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <?= csrf() ?>

        <?= component('form/form-file-input', [
            'name'  => 'preview',
            'label' => $hive->get('admin.preview'),
            'with_alt' => true,
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-textarea', [
            'name'  => 'description',
            'label' => $hive->get('admin.description'),
            'attrs' => [
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'image',
            'label' => $hive->get('admin.image'),
            'with_alt' => true,
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-wysiwyg', [
            'name'  => 'html',
            'label' => $hive->get('admin.content'),
            'attrs' => [
                'required' => true,
            ],
        ]) ?>

        <div class="flex justify-between gap-2.5">
            <?= component('ui/auth-button', [
                'slot' => $hive->get('admin.save'),
                'attrs' => ['type' => 'submit']
            ]) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

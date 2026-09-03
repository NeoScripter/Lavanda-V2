<?php

extract(component_props(
    required: ['article'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/item-layout', [
    'heading' => $hive->get('admin.articles'),
    'title' => $hive->get('admin.articles'),
]);?>

<div class="space-y-6">

    <?= component('ui/subheading', ['title' => $hive->get('admin.edit_article')]) ?>

    <form action="<?= $hive->alias('admin_articles_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('form/form-file-input', [
            'name'  => 'preview',
            'label' => $hive->get('admin.preview'),
            'with_alt' => true,
            'value'    => [$article['preview']],
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-textarea', [
            'name'  => 'description',
            'label' => $hive->get('admin.description'),
            'attrs' => [
                'required' => true,
                'value'    => $article['description'],
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'image',
            'label' => $hive->get('admin.image'),
            'with_alt' => true,
            'value'    => [$article['image']],
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-wysiwyg', [
            'name'  => 'html',
            'label' => $hive->get('admin.content'),
            'attrs' => [
                'required' => true,
                'value'    => $article['html'],
            ],
        ]) ?>

        <div class="flex justify-start gap-4.5">
            <?= component(
                'ui/auth-button',
                [
                    'slot' => $hive->get('admin.save'),
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
            <?= component(
                'ui/auth-button',
                [
                    'slot' => $hive->get('admin.cancel'),
                    'href' => $hive->alias('admin_articles_index', [], ['variant' => $article['variant']]),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>

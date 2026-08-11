<?php slot('layouts/admin-layout', [
    'heading' => 'Newsletter',
    'title' => 'Newsletter'
]); ?>

<?php $hive = \Base::instance(); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', [
            'title'       => 'Edit a newsletter',
            'class'       => "[&>h3,&>p]:animate-none",
        ]) ?>

        <form action="<?= $hive->alias('admin_news_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="put">
            <?= csrf() ?>

            <?= component('form/form-input', [
                'name'  => 'title',
                'label' => 'Newsletter title',
                'attrs' => [
                    'type'     => 'text',
                    'value'    => $article['title'],
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-input', [
                'name'  => 'created_at',
                'label' => 'Date',
                'attrs' => [
                    'type'     => 'date',
                    'value'    => $article['created_at'],
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-file-input', [
                'name'  => 'preview',
                'label' => 'Image',
                'can_delete'  => false,
                'with_alt' => true,
                'value'    => [$article['image'] ?? null],
                'attrs' => [
                    'required' => false,
                    'multiple' => false,
                ],
            ]) ?>

            <?= component('form/form-textarea', [
                'name'  => 'summary',
                'label' => 'Newsletter description',
                'attrs' => [
                    'required' => true,
                    'value'    => $article['summary'],
                ],
            ]) ?>

            <?= component('form/form-wysiwyg', [
                'name'  => 'body',
                'label' => 'Newsletter content',
                'attrs' => [
                    'required' => true,
                    'value'    => $article['body'],
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

            <div class="flex justify-start gap-4.5">
                <?= component(
                    'ui/auth-button',
                    ['slot' => 'Save', 'attrs' => ['type' => 'submit']]
                ) ?>
                <?= component(
                    'ui/auth-button',
                    [
                        'slot' => 'Cancel',
                        'href' => $hive->alias('admin_news_index'),
                        'variant' => 'secondary',
                        'attrs' => ['type' => 'submit']
                    ]
                ) ?>
            </div>
        </form>
    </div>
</div>

<?php end_slot(); ?>

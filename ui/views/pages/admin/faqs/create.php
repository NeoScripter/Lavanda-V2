<?php

$hive = \Base::instance();

slot('layouts/admin/item-layout', [
    'heading' => $hive->get('admin.faqs'),
    'title' => $hive->get('admin.faqs'),
]);
?>

<div class="space-y-6">
        <?= component('admin/ui/subheading', ['title' => $hive->get('admin.create_faq')]) ?>

        <form action="<?= \Base::instance()->alias('admin_faqs_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <?= csrf() ?>

            <?= component('admin/form/form-input', [
                'name'  => 'question',
                'label' => $hive->get('admin.question'),
                'attrs' => [
                    'type'     => 'text',
                    'required' => true,
                ],
            ]) ?>

            <?= component('admin/form/form-textarea', [
                'name'  => 'answer',
                'label' => $hive->get('admin.answer'),
                'attrs' => [
                    'required' => true,
                ],
            ]) ?>

            <div class="flex items-center gap-4.5">
                <?= component('admin/ui/auth-button', [
                    'slot' => $hive->get('admin.save'),
                    'attrs' => ['type' => 'submit']
                ]) ?>

                <?= component('admin/ui/auth-button', [
                    'slot' => $hive->get('admin.cancel'),
                    'href' => $hive->alias('admin_faqs_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]) ?>

            </div>
        </form>
</div>

<?php end_slot(); ?>

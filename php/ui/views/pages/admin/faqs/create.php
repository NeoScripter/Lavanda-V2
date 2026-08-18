<?php

$hive = \Base::instance();

slot('layouts/faq-grid-layout', [
    'heading' => $hive->get('admin.faqs'),
    'title' => $hive->get('admin.faqs'),
]); 
?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">

        <?= component('ui/subheading', ['title' => $hive->get('admin.create_a_faq')]) ?>

        <form action="<?= \Base::instance()->alias('admin_faqs_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
            <?= csrf() ?>

            <?= component('form/form-input', [
                'name'  => 'name',
                'label' => $hive->get('admin.faq_name'),
                'attrs' => [
                    'type'     => 'text',
                    'required' => true,
                ],
            ]) ?>

            <?= component('form/form-textarea', [
                'name'  => 'advice',
                'label' => $hive->get('admin.faq_advice'),
                'attrs' => [
                    'required' => true,
                ],
            ]) ?>

            <div class="flex justify-between gap-2.5">
                <?php slot('components/ui/auth-button', ['attrs' => ['type' => 'submit']]); ?>
                <?= $hive->get('admin.save') ?>
                <?php end_slot(); ?>
            </div>
        </form>
    </div>
</div>

<?php end_slot(); ?>

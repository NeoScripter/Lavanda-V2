<?php

extract(component_props(
    required: ['file'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();
?>


<?php $alt_modal_id = uniqid('alt_modal_'); ?>
<div class='my-2 relative min-h-[2em] group px-3 p-1 border border-input shadow-xs truncate rounded-sm overflow-clip'>

    <?= $file['alt'] !== '' ? $file['alt'] : 'Enter image alt...' ?>

    <button
        component-modal-show
        data-modal-id="<?= $alt_modal_id ?>"
        type="button"
        class="absolute bg-black/80 transition-opacity font-medium opacity-0 group-hover:opacity-100 p-1 inset-0 text-white">
        <?= $hive->get("admin.update_image_alt") ?>
    </button>
</div>

<?= component(
    'form/input-error',
    ['message' => \Flash::instance()->getKey("errors.alt")]
) ?>

<?php slot('components/layout/modal', ['modal_id' => $alt_modal_id]); ?>

<form action="<?= $hive->alias('admin_images_update', ['id' => $file['id']]) ?>"
    method="post"
    class="space-y-6 w-120">
    <input type="hidden" name="_method" value="put">
    <?= csrf() ?>

    <?= component('form/form-textarea', [
        'name'  => 'alt',
        'label' => $hive->get('admin.image_alternative_text'),
        'attrs' => [
            'type'     => 'text',
            'value'    => $file['alt'],
            'required' => true,
        ],
    ]) ?>

    <div class="flex justify-start gap-3.5">
        <?= component(
            'ui/auth-button',
            ['slot' => 'Save', 'attrs' => ['type' => 'submit']]
        ) ?>
        <?= component(
            'ui/auth-button',
            [
                'slot' => 'Cancel',
                'variant' => 'secondary',
                'attrs' => ['type' => 'button', 'component-modal-dismiss' => true]
            ]
        ) ?>
    </div>
</form>
<?php end_slot(); ?>

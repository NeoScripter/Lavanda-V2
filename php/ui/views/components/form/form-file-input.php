<?php

extract(component_props(
    required: [],
    optional: [
        'name' => '',
        'label' => '',
        'value' => [],
        'class' => '',
        'attrs' => [],
        'with_alt' => false,
        'can_delete' => true
    ],
    props: get_defined_vars(),
));

$error = \Flash::instance()->getKey("errors.{$name}") ?? '';
$uid = uniqid('file_input_');

$files = array_filter($value);

$file_name = $name;
if (! empty($file_name) && array_key_exists('multiple', $attrs) && $attrs['multiple'] === true) {
    $file_name .= '[]';
}

$attrs = array_merge(
    ['aria-invalid' => $error ? 'true' : 'false'],
    ['name' => $file_name],
    $attrs,
);
$required = isset($attrs['required']) && $attrs['required'] === true;

$attr_string = serialize_attrs($attrs);

$hive = \Base::instance();
?>
<div class="grid gap-2">
    <?php if ($label): ?>
        <?= component('form/label', [
            'slot'  => $label . ($required ? '<span class="text-orange-500">*</span>' : ''),
            'attrs' => ['for' => $uid, 'id' => $uid],
        ]) ?>
    <?php endif ?>

    <file-pond>
        <input id="<?= $uid ?>" type="file" class="<?= $class ?>" <?= $attr_string ?> />
    </file-pond>

    <ul component-file-grid class="grid gap-2 grid-cols-[repeat(auto-fill,minmax(12rem,1fr))]"></ul>

    <?php if ($with_alt) : ?>
        <fieldset class="mt-2">
            <legend component-legend class="mb-2 hidden font-medium">
                <?= $hive->get('admin.image_alternative_text') ?>
            </legend>
            <ol component-file-alts class="grid gap-2 list-decimal list-inside" data-alt-name="<?= "alt_{$name}[]" ?>">
            </ol>
        </fieldset>

        <template component-alt-template>
            <li class="[&>input]:max-w-[calc(100%-3ch)]">
                <?= component('form/input', [
                    'attrs' => ['placeholder' => $hive->get('admin.a_squirrel_is_sitting_on_a_tree')],
                    'class' => 'inline'
                ]) ?>
            </li>
        </template>
    <?php endif; ?>

    <template component-image-template>
        <li class="aspect-square rounded-sm overflow-clip">
            <img class="size-full object-cover object-center" src="" alt="">
        </li>
    </template>

    <?php if (! empty($files)) : ?>
        <?php if ($label): ?>
            <?= component('form/label', [
                'slot'  => 'Current Files',
                'class' => 'mt-2'
            ]) ?>
        <?php endif ?>

        <ul class="grid gap-2 grid-cols-[repeat(auto-fill,minmax(12rem,1fr))]">
            <?php foreach ($files as $file) : ?>
                <?php if ($file instanceof \Http\Models\Image) : ?>

                    <?php $modal_id = uniqid('modal_'); ?>

                    <li>
                        <div class="aspect-square relative">
                            <?php if ($can_delete) : ?>
                                <button
                                    component-modal-show
                                    data-modal-id="<?= $modal_id ?>"
                                    type="button"
                                    class="absolute rounded-sm transition-colors hover:bg-red-500 size-7 p-1 bg-red-400 top-0 right-0 text-white">
                                    <?= svg('x') ?>
                                </button>
                            <?php endif; ?>

                            <img class="size-full rounded-sm object-cover object-center" src="<?= $file->src .  "-mb.webp" ?>" alt="" />

                            <?php if ($can_delete) : ?>
                                <?= component('ui/delete-confirmation-modal', [
                                    'delete_url' => $hive->alias("admin_images_destroy", ['id' => $file->id]),
                                    'modal_id'   => $modal_id,
                                    'class'   => 'rounded-sm',
                                ]) ?>

                            <?php endif; ?>
                        </div>

                        <?php $alt_modal_id = uniqid('alt_modal_'); ?>

                        <div class='my-2 relative group px-3 p-1 border border-input shadow-xs truncate rounded-sm overflow-clip'>

                            <?= $file->alt ?>
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

                        <form action="<?= $hive->alias('admin_images_update', ['id' => $file->id]) ?>"
                            method="post"
                            class="space-y-6 w-120">
                            <input type="hidden" name="_method" value="put">
                            <?= csrf() ?>

                            <?= component('form/form-textarea', [
                                'name'  => 'alt',
                                'label' => $hive->get('admin.image_alternative_text'),
                                'attrs' => [
                                    'type'     => 'text',
                                    'value'    => $file->alt,
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
                    </li>
                <?php elseif (is_string($file)): ?>
                    <div class="mt-2">
                        <a
                            href="<?= $file ?>"
                            target="_blank"
                            class="font-medium inline-flex items-center transition-colors hover:text-muted-foreground">
                            <span class="mr-1.5 inline-block [&>svg]:size-5">
                                <?php include(APP_DIR . '/public/assets/svgs/download-file.svg'); ?>
                            </span>
                            <?= substr($file, strrpos($file, '/') + 1) ?>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?= component('form/input-error', ['message' => $error]) ?>
</div>

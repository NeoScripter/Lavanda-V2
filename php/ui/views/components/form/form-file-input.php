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

    <?= component('form/file-input-templates', compact('name', 'with_alt')) ?>

    <?php if (! empty($files)) : ?>
        <?php if ($label): ?>
            <?= component('form/label', [
                'slot'  => $hive->get('admin.current_files'),
                'class' => 'mt-2'
            ]) ?>
        <?php endif ?>

        <ul class="grid gap-2 grid-cols-[repeat(auto-fill,minmax(12rem,1fr))]">
            <?php foreach ($files as $file) : ?>
                <?php if (isset($file['src'])) : ?>

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

                            <img class="size-full rounded-sm object-cover object-center" src="<?= $file['src'] .  "-mb.webp" ?>" alt="" />

                            <?php if ($can_delete) : ?>
                                <?= component('ui/delete-confirmation-modal', [
                                    'delete_url' => $hive->alias("admin_images_destroy", ['id' => $file['id']]),
                                    'modal_id'   => $modal_id,
                                    'class'   => 'rounded-sm',
                                ]) ?>

                            <?php endif; ?>
                        </div>

                        <?php if ($with_alt) : ?>
                            <?= component('form/image-alt-modal', ['file' => $file]) ?>
                        <?php endif; ?>
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

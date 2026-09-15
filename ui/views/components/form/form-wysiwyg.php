<?php

extract(component_props(
    required: ['name', 'label', 'attrs'],
    optional: ['class' => '', 'value' => ''],
    props: get_defined_vars(),
));

$flash = \Flash::instance();

$error = $flash->getKey("errors.{$name}") ?? '';
$value = $attrs['value'] ?? '';
$uid = uniqid('wysiwyg_');

if ($flash->hasKey("values.{$name}")) {
    $value = htmlspecialchars($flash->getKey("values.{$name}"));
}

$required = isset($attrs['required']) && $attrs['required'] === true;

?>
<div class="grid gap-2">
    <?php if ($label): ?>
        <?= component('form/label', [
            'slot'  => $label . ($required ? '<span class="text-orange-500">*</span>' : ''),
            'attrs' => ['for' => $uid],
        ]) ?>
    <?php endif ?>


    <?= component('form/wysiwyg', [
        'class' => $class,
        'value' => $value,
        'name' => $name,
        'required' => $required,
        'id' => $uid,
    ]) ?>

    <?= component('form/input-error', ['message' => $error]) ?>
</div>

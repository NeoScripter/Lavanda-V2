<?php

extract(component_props(
    required: ['name'],
    optional: ['class' => '', 'label' => '', 'attrs' => [], 'value' => ''],
    props: get_defined_vars(),
));

$flash = \Flash::instance();

$error = $flash->getKey("errors.{$name}") ?? '';
$value = $attrs['value'] ?? $flash->getKey("values.{$name}") ?? $value;
$uid = uniqid('textarea_');

$attrs = array_merge(
    $attrs,
    ['aria-invalid' => $error ? 'true' : 'false'],
    ['name' => $name],
    ['id' => $uid],
);
$required = isset($attrs['required']) && $attrs['required'] === true;

?>
<div class="grid gap-2">
    <?php if ($label): ?>
        <?= component('web/form/label', [
            'slot'  => $label . ($required ? '<span class="text-orange-500">*</span>' : ''),
            'attrs' => ['for' => $uid],
        ]) ?>
    <?php endif ?>

    <?= component('web/form/textarea', [
        'class' => $class,
        'slot' => $value,
        'attrs' => $attrs,
    ]) ?>

    <?= component('web/form/input-error', ['message' => $error]) ?>
</div>

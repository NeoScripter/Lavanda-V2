<?php

$name = $name ?? '';
$label = $label ?? '';
$error = \Flash::instance()->getKey("errors.{$name}") ?? '';
$value = $attrs['value'] ?? \Flash::instance()->getKey("values.{$name}") ?? '';
$class = $class ?? '';
$attrs = $attrs ?? [];
$uid = uniqid('input_');

$attrs = array_merge(
    $attrs,
    ['aria-invalid' => $error ? 'true' : 'false'],
    ['value' => $value],
    ['name' => $name],
    ['id' => $uid],
);
$required = isset($attrs['required']) && $attrs['required'] === true;
$is_pwd = isset($attrs['type']) && $attrs['type'] === 'password';

?>
<div class="grid gap-2">
    <?php if ($label): ?>
        <?= component('form/label', [
            'slot'  => $label . ($required ? '<span class="text-orange-500">*</span>' : ''),
            'attrs' => ['for' => $uid],
        ]) ?>
    <?php endif ?>

    <?= component($is_pwd ? 'form/password-input' : 'form/input', [
        'class' => $class,
        'attrs' => $attrs,
    ]) ?>

    <?= component('form/input-error', ['message' => $error]) ?>
</div>

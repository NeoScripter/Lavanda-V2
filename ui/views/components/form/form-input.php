<?php

extract(component_props(
    required: ['name'],
    optional: ['name' => '', 'label' => '', 'class' => '', 'attrs' => [], 'options' => []],
    props: get_defined_vars(),
));

$error = \Flash::instance()->getKey("errors.{$name}") ?? '';
$value = $attrs['value'] ?? \Flash::instance()->getKey("values.{$name}") ?? '';
$uid = uniqid('input_');

$attrs = array_merge(
    $attrs,
    ['aria-invalid' => $error ? 'true' : 'false'],
    ['value' => $value],
    ['name' => $name],
    ['id' => $uid],
    !empty($options) ? ['list' => $uid . '_list'] : [],
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

    <?php if (isset($attrs['list']) && !empty($options)) : ?>
        <datalist id="<?= $uid ?>_list">
            <?php foreach ($options as $option) : ?>
                <option value="<?= $option ?>">
                    <?= $option ?>
                </option>
            <?php endforeach; ?>
        </datalist>
    <?php endif; ?>

    <?= component('form/input-error', ['message' => $error]) ?>
</div>

<?php

extract(component_props(
    required: ['name', 'label'],
    optional: ['class' => '', 'value' => [], 'attrs' => []],
    props: get_defined_vars(),
));

$flash = \Flash::instance();
$hive = \Base::instance();

$error = $flash->getKey("errors.{$name}") ?? '';
$uid = uniqid('accordion_');

if ($flash->hasKey("values.{$name}")) {
    $value = $flash->getKey("values.{$name}");
}

$required = isset($attrs['required']) && $attrs['required'] === true;

?>
<div component-form-accordion
    class="grid gap-4 <?= $class ?>">

    <?php if ($label): ?>
        <?= component('form/label', [
            'slot'  => $label . ($required ? '<span class="text-orange-500">*</span>' : ''),
        ]) ?>
    <?php endif ?>

    <hr />
    <ol component-form-accordion-list
        class='space-y-4'>
        <?php if (empty($value)) : ?>
            <li>
                <label>
                    <?= $hive->get('admin.question') ?>
                    <?= component('form/input', [
                        'class' => 'mt-1 mb-3',
                        'attrs' => [
                            'name' => "{$name}[0][question]",
                            'required' => $required,
                            'component-accordion-question' => true,
                        ]
                    ]) ?>
                </label>

                <label>
                    <?= $hive->get('admin.answer') ?>
                    <?= component('form/textarea', [
                        'class' => 'mt-1',
                        'attrs' => [
                            'name' => "{$name}[0][answer]",
                            'required' => $required,
                            'component-accordion-answer' => true,
                        ]
                    ]) ?>
                </label>
            </li>
        <?php else : ?>
            <?php foreach ($value as $idx => $faq) : ?>
                <li>
                    <label>
                        <?= $hive->get('admin.question') ?>
                        <?= component('form/input', [
                            'class' => 'mt-1 mb-3',
                            'attrs' => [
                                'value' => $faq['question'],
                                'required' => $required,
                                'name' => "{$name}[{$idx}][question]",
                                'component-accordion-question' => true,
                            ]
                        ]) ?>
                    </label>

                    <label>
                        <?= $hive->get('admin.answer') ?>
                        <?= component('form/textarea', [
                            'class' => 'mt-1',
                            'slot' => $faq['answer'],
                            'attrs' => [
                                'required' => $required,
                                'name' => "{$name}[{$idx}][answer]",
                                'component-accordion-answer' => true,
                            ]
                        ]) ?>
                    </label>
                </li>
            <?php endforeach; ?>

        <?php endif; ?>
    </ol>

    <hr />

    <div class='flex items-center justify-end gap-4'>
        <?= component('ui/auth-button', [
            'class' => 'mt-1 w-fit',
            'slot' => $hive->get('admin.add'),
            'variant' => 'outline',
            'size' => 'sm',
            'attrs' => [
                "component-accordion-add-item-btn" => true,
                'type' => 'button'
            ]
        ]) ?>

        <?= component('ui/auth-button', [
            'class' => "mt-1 w-fit " . (empty($value) || count($value) === 1) ? 'hidden!' : '',
            'slot' => $hive->get('admin.delete'),
            'variant' => 'destructive',
            'size' => 'sm',
            'attrs' => [
                "component-accordion-delete-item-btn" => true,
                'type' => 'button'
            ]
        ]) ?>
    </div>
    <?= component('form/input-error', ['message' => $error]) ?>
</div>

<?php

extract(component_props(
    required: ['with_alt', 'name'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();
?>
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

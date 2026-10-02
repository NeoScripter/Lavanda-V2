<?php

$id = 'deck-' . uniqid();

extract(component_props(
    required: ['count', 'slot'],
    optional: ['gap' => 0.4, 'width' => 10, 'attrs' => []],
    props: get_defined_vars(),
)); ?>

<?php if ($count > 0) : ?>
    <style>
        #<?= $id ?> {
            max-width: calc(<?= ($count + 1) * $gap ?>rem + <?= $width ?>rem);
            padding-right: <?= $width ?>rem;
            grid-template-columns: repeat(auto-fill, <?= $gap ?>rem);
        }

        #<?= $id ?>>li {
            width: <?= $width ?>rem;
        }
    </style>

    <ul id='<?= $id ?>'
        class='grid max-w-full gap-y-1 mx-auto' <?= serialize_attrs($attrs) ?>>
        <?= $slot ?>
    </ul>
<?php else: ?>
    <p>Cards are not loaded yet :(</p>
<?php endif; ?>

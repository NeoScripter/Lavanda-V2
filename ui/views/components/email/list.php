<?php

extract(component_props(
    required: ['items'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<ul>
    <?php foreach ($items as $item) : ?>
        <li><?= $item ?></li>
    <?php endforeach; ?>
</ul>

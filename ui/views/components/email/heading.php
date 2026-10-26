<?php

extract(component_props(
    required: ['label'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<h2 style="margin:0 0 16px;color:#18181b;font-size:18px;"><?= html_entity_decode($label) ?></h2>

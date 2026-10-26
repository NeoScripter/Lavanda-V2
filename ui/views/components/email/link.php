<?php

extract(component_props(
    required: ['label', 'href'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<a href="<?= $href ?>" style="display:inline-block;background-color:#635782;color:#ffffff;text-decoration:none;padding:8px 14px;border-radius:4px;font-size:14px;font-weight:medium;"><?= $label ?></a>

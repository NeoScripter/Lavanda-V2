<?php

extract(component_props(
    required: ['item'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<li class='bg-white rounded-2xl shadow-accent px-6 py-10 h-65 flex flex-col'>

    <h3 class='text-xl mt-auto text-left uppercase'><?= $item['title'] ?></h3>
    <p><?= $item['description'] ?></p>
</li>

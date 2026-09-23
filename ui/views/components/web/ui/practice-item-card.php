<?php

extract(component_props(
    required: ['item'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<li class='bg-white rounded-2xl shadow-accent px-6 py-8 md:px-8 md:py-10 h-65 md:h-75 flex flex-col'>

    <h3 class='text-xl mt-auto text-left md:text-2xl uppercase'><?= $item['title'] ?></h3>
    <p class='lg:text-lg'><?= mb_substr($item['description'], 0, 50) . '...' ?></p>
</li>

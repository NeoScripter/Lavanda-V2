<?php

extract(component_props(
    required: ['item'],
    optional: [],
    props: get_defined_vars(),
));

$idx = rand(1, 6);

?>

<li class='rounded-2xl relative bg-no-repeat overflow-clip before:absolute before:inset-0 before:bg-linear-to-b before:from-transparent before:to-white/91 bg-cover bg-center shadow-accent px-6 py-8 md:px-8 md:py-10 h-65 md:h-75 flex flex-col'
    style="background-image: url(<?= "/assets/images/shared/card-bg/card-bg-$idx.webp" ?>)">

    <h2 class='text-xl mt-auto text-left md:text-2xl font-bold isolate uppercase'><?= $item['title'] ?></h2>
    <p class='lg:text-lg isolate'><?= mb_substr($item['description'], 0, 53) . (strlen($item['description']) > 53 ? '...' : '') ?></p>
</li>

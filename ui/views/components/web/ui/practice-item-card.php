<?php

extract(component_props(
    required: ['item'],
    optional: ['attrs' => [], 'class' => '', 'max_char' => 53],
    props: get_defined_vars(),
));

$idx = rand(1, 6);

?>

<li data-practice-item-id="<?= $item['id'] ?>"
    class="<?= cc('rounded-2xl relative focus-within:ring-blue-400 focus-within:ring-4 aria-selected:bg-primary aria-selected:text-white group justify-end bg-no-repeat overflow-clip before:absolute before:inset-0 before:bg-linear-to-b before:from-transparent before:to-white/91 aria-selected:before:from-transparent aria-selected:before:to-primary bg-cover bg-center shadow-accent px-6 py-8 md:px-8 md:py-10 min-h-65 md:min-h-75 flex flex-col', $class) ?>"
    style="background-image: url(<?= "/assets/images/shared/card-bg/card-bg-$idx.webp" ?>)"
    <?= serialize_attrs($attrs) ?>>

    <h2 class='text-xl text-left md:text-2xl font-bold group-aria-selected:text-white isolate uppercase'><?= $item['title'] ?></h2>
    <p class='lg:text-lg isolate'><?= mb_substr($item['description'], 0, $max_char) . (mb_strlen($item['description']) > $max_char ? '...' : '') ?></p>

    <button component-pic-button
        type='button'
        class='absolute inset-0 cursor-pointer'>
    </button>
</li>

<?php

extract(component_props(
    required: ['slot'],
    optional: ['class' => '', 'style' => null],
    props: get_defined_vars(),
)); ?>

<?php slot('components/web/layout/hero', [
    'class' => "bg-white pb-0 sm:pb-0 relative rounded-b-3xl!"
]); ?>
<span class='absolute -bottom-px before:right-0 inset-x-0 before:-left-2 rounded-b-2xl overflow-clip before:bg-no-repeat aspect-10/1 before:absolute before:inset-0 before:bg-cover block before:bg-[url("/assets/images/shared/hero-light/bottom-stripe.webp")]'></span>
<?= $slot ?>

<?php end_slot(); ?>

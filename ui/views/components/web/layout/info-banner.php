
<?php
extract(component_props(
    required: ['slot'],
    optional: ['class' => ''],
    props: get_defined_vars(),
)); ?>

<div class="<?= cc('border-2 border-primary rounded-xl *:text-sm! pt-8 pb-4 px-4 sm:px-8 relative', $class) ?>">
    <figure class='size-10 absolute top-0 left-1/2 -translate-1/2 flex items-center justify-center text-white rounded-full bg-primary'>
        <span class='block size-1/2'>
        <?= svg('info.svg') ?>
        </span>
    </figure>
    <?= $slot ?>
</div>


<?php

extract(component_props(
    required: ['title', 'img_fg', 'img_bg', 'words'],
    optional: ['class' => ''],
    props: get_defined_vars(),
));

$classes = ['left-[5%] top-[30%]', 'left-[10%] top-[42.5%]', 'left-[12%] top-[55%]', 'left-[11%] top-[67.5%]','right-[10%] top-[10%]', 'right-[7%] top-[24%]', 'right-[0%] top-[40%]', 'right-[0%] top-[60%]'];

?>
<li class='<?= $class ?> max-w-75 w-full mx-auto sm:max-w-100'>
    <h5 class='mb-5 shadow-md uppercase text-primary px-[1em] w-fit mx-auto rounded-full py-[0.5em] font-medium rounded-br-none'>
        <?= $title ?>
    </h5>

    <div style="background-image: url(<?= $img_bg ?>)"
        class="bg-cover relative flex items-center justify-center aspect-5/6 bg-center">
        <?= component('admin/ui/image', [
            'sizes'    => 'mb',
            'alt' => 'Stairs',
            'path'     => $img_fg,
            'prt_class' => 'h-2/3',
            'img_class' => 'size-full object-contain!',
        ]) ?>

        <?php foreach ($words as $idx => $word) : ?>
            <span class='absolute text-primary font-medium text-center text-sm max-w-25 <?= $classes[$idx] ?>'>
                <?= $word ?>
            </span>

        <?php endforeach; ?>
    </div>
</li>

<?php
$hive = \Base::instance();

extract(component_props(
    required: [],
    optional: ['class' => ''],
    props: get_defined_vars(),
)); ?>

<div cmp-flip-coin
    style="--rotation: 180"
    class="<?= cc('relative aspect-square still select-none shrink-0', $class) ?>">
    <div cmp-surface class='relative size-full'>
        <?= component('shared/ui/image', [
            'sizes'    => 'mb',
            'path'     => '/assets/images/pages/iching/tales',
            'alt'     => 'Flipside of a golden coin',
            'prt_class' => 'size-full bg-contain! absolute!',
            'img_class' => 'object-contain!',
        ]) ?>
        <?= component('shared/ui/image', [
            'sizes'    => 'mb',
            'path'     => '/assets/images/pages/iching/heads',
            'alt'     => 'Front side of a golden coin',
            'prt_class' => 'size-full absolute! bg-contain!',
            'img_class' => 'object-contain!',
        ]) ?>
        <span cmp-shadow></span>
    </div>
</div>

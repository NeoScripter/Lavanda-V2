<?php
$hive = \Base::instance();

extract(component_props(
    required: [],
    optional: ['class' => ''],
    props: get_defined_vars(),
)); ?>

<div cmp-flip-coin
    class="<?= cc('relative aspect-square select-none overflow-clip rounded-xl shrink-0', $class) ?>">
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => '/assets/images/pages/iching/tales',
        'alt'     => 'Flipside of a golden coin',
        'prt_class' => 'size-full bg-contain! absolute! transition-transform rotate-y-180 backface-hidden inset-0',
        'img_class' => 'object-contain!',
    ]) ?>
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => '/assets/images/pages/iching/heads',
        'alt'     => 'Front side of a golden coin',
        'prt_class' => 'size-full bg-contain! isolate backface-hidden transition-transform',
        'img_class' => 'object-contain!',
    ]) ?>
</div>

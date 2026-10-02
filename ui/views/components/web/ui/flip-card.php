<?php
$hive = \Base::instance();

extract(component_props(
    required: ['card'],
    optional: ['class' => ''],
    props: get_defined_vars(),
)); ?>

<li cmp-flip-card cmp-card data-id="<?= $card['id'] ?>" class="<?= cc('relative aspect-160/229 overflow-clip rounded-xl shrink-0', $class) ?>">
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => $card['front_src'],
        'alt'     => $card['front_alt'],
        'prt_class' => 'size-full bg-contain! absolute! transition-transform rotate-y-180 backface-hidden inset-0',
        'img_class' => 'object-contain!',
    ]) ?>
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => $card['back_src'],
        'alt'     => $card['back_alt'],
        'prt_class' => 'size-full bg-contain! isolate backface-hidden transition-transform',
        'img_class' => 'object-contain!',
    ]) ?>
</li>

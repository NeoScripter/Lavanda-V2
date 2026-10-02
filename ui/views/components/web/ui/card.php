<?php
$hive = \Base::instance();

extract(component_props(
    required: ['card'],
    optional: ['class' => '', 'side' => 'back'],
    props: get_defined_vars(),
)); ?>

<li cmp-card 
    data-img-src="<?= $card['front_src'] ?>" 
    data-img-alt="<?= $card['front_alt'] ?>" 
    class="<?= cc('relative aspect-160/229 overflow-clip rounded-xl shrink-0', $class) ?>">
    <?= component('shared/ui/image', [
        'sizes'    => 'mb',
        'path'     => $card[$side . '_src'],
        'alt'     => $card[$side . '_alt'],
        'prt_class' => 'size-full bg-contain! isolate transition-transform',
        'img_class' => 'object-contain!',
    ]) ?>
</li>

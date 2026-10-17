<?php $dices = require(APP_DIR . '/ui/data/models/dices.php'); ?>
<?php $sides = ['front', 'up', 'left', 'right', 'bottom', 'back'] ;?>

<div class="relative [--side:12.5rem] w-(--side) h-[calc(var(--side)/1.1)] flex items-center justify-center">
    <div cmp-dice class="throw">
        <?php foreach ($sides as $idx => $side) : ?>
            <div cmp-dice-face class="<?= $side ?>" style="--size: calc(var(--side)/2);">
                <?= component('shared/ui/image', [
                    'path' => $dices[$idx]['image'],
                    'alt' => $dices[$idx]['meaning'],
                    'sizes' => 'mb',
                    'prt_class' => 'aspect-square bg-contain! size-full',
                    'img_class' => 'size-full object-contain!',
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

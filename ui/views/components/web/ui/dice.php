<?php $dices = require(APP_DIR . '/ui/data/models/dices.php'); ?>
<?php $sides = ['front', 'up', 'left', 'right', 'bottom', 'back']; ?>

<div class="relative [--side:12.5rem] w-(--side) h-[calc(var(--side)*1.1)] has-[[cmp-dice-name]:not(.hidden)]:mb-6 flex flex-col items-center justify-center">
    <div cmp-dice>
        <?php foreach ($sides as $idx => $side) : ?>
            <div cmp-dice-face
                data-id="<?= $dices[$idx]['id'] ?>"
                data-name="<?= $dices[$idx]['name'] ?>"
                class="<?= $side ?>" style="--size: calc(var(--side)/2);">
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
    <div cmp-dice-name class='text-white text-3xl absolute inset-x-0 hidden text-center font-bold translate-x-[calc(var(--side)/30)] bottom-0'>HA</div>
</div>

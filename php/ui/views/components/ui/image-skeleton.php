<?php $text = $text ?? 'Refresh the page to see updates'; ?>

<div class="group relative w-full flex aspect-3/2 items-center justify-center shrink-0 rounded-xl">
    <span class="block absolute inset-0 rounded-xl bg-gray-300 animate-pulse"></span>
    <div class="size-14">
        <?= svg('spinner') ?>
    </div>
    <?= component('ui/hint', ['text' => $text]) ?>
</div>

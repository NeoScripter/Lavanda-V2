<?php $items = [
    ['id' => 1, 'title' => '1 карта', 'description' => "Простая и быстрая практика. Карта подскажет, на что обратить внимание прямо сейчас — какое настроение, мысль или энергия сопровождает вас сегодня.", 'num' => 1],
    ['id' => 2, 'title' => '3 карты', 'description' => "Расклад, который помогает понять динамику происходящего: что уже позади, что важно сейчас и куда направлено развитие ситуации.", 'num' => 3],
    ['id' => 3, 'title' => '5 карт', 'description' => "Более глубокий взгляд. Этот расклад показывает, как внутренние и внешние силы влияют на вас, и что поможет действовать с уверенностью и спокойствием.", 'num' => 5],
]; ?>

<ul
    class="grid [--sq-size:min(100%,20.6rem)] md:[--sq-size:25.6rem] -mt-12 sm:-mt-25 px-2 relative grid-cols-[repeat(auto-fill,var(--sq-size))] justify-center gap-8 md:gap-10">

    <?php foreach ($items as $idx => $item) : ?>
        <?= component('web/ui/practice-item-card', [
            'item' => $item,
            'class' => 'justify-center' . ($idx === 2 ? ' md:col-span-2 md:max-w-(--sq-size) md:mx-auto xl:col-span-1' : ''),
            'max_char' => 150,
            'attrs' => ['data-num-rounds' => $item['num'], 'cmp-reveal-game-btn' => true]
        ]) ?>
    <?php endforeach; ?>

</ul>

<?php $hive = \Base::instance(); ?>

<?php extract(component_props(
    required: [],
    optional: ['label' => $hive->get("web.получить_ответ")],
    props: get_defined_vars()
)); ?>

<div class='flex flex-wrap items-center gap-6 lg:gap-x-8 mt-10 mr-auto'>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $label,
        'class' => 'w-fit',
        'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
    ]) ?>
    <?= component('web/ui/button', [
        'variant' => 'muted',
        'slot' => $hive->get("web.следующий_раздел"),
        'href' => next_game_route(),
        'class' => 'w-fit',
    ]) ?>
</div>

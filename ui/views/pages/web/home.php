<?php $hive = \Base::instance(); ?>
<?php slot('layouts/web/app-layout', [
    'title' => 'Главная',
]); ?>

<div class="p-2">
    <div>Hell 2o 9 world</div>
    <h1>Привет мир</h1>
    <?=  /* component('web/ui/button', ['slot' => 'hello world']) */ '' ?>
    <?php slot('components/web/ui/button', ['variant' => 'outline', 'size' => 'md']); ?>
    hello world
    <?php end_slot(); ?>
</div>


<?php end_slot(); ?>

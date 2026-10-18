<?php

extract(component_props(
    required: ['dice'],
    optional: ['themes'],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/admin/app-layout', [
    'heading' => $hive->get('admin.dices'),
    'title' => $hive->get('admin.dices'),
]);
slot('layouts/admin/theme-layout', [
    'model' => 'dices',
    'model_id' => $dice['id'],
    'themes' => $themes
]); ?>

<?php $dices = require(APP_DIR . '/ui/data/models/dices.php'); ?>

<div class="space-y-6">

    <?= component('admin/ui/subheading', ['title' => $hive->get('admin.dice')]) ?>

    <ul class='grid gap-2 grid-cols-[repeat(auto-fill,minmax(8rem,1fr))]'>
        <?php foreach (explode('|', $dice['diceable_id']) as $id) : ?>
            <?php $item = array_find($dices, fn($dice) => $dice['id'] === (int) $id); ?>
            <li class="relative w-full">
                <?= component('shared/ui/image', [
                    'sizes'    => 'mb',
                    'path'     => $item['image'],
                    'prt_class' => 'w-full shrink-0 rounded-xl aspect-square bg-contain!',
                    'img_class' => 'object-contain!',
                ]) ?>
                <p class='uppercase text-center text-2xl font-bold mt-2'><?= $item['name'] ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php end_slot(); ?>
<?php end_slot(); ?>

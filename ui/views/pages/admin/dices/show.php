<?php
extract(component_props(
    required: ['dice'],
    optional: ['themes' => []],
    props: get_defined_vars(),
));
$hive = \Base::instance(); ?>
<?php slot('layouts/admin/app-layout', [
    'heading' => $hive->get('admin.dices'),
    'title' => $hive->get('admin.dices')
]);

$dices = require(APP_DIR . '/ui/data/models/dices.php'); ?>

<div class="space-y-6">
    <?= component('admin/ui/subheading', ['title' => $hive->get('admin.dice')]) ?>

    <div class="space-y-6 max-w-260">

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

        <?php if (!empty($themes)) : ?>
            <div>
                <h3 class="my-6 font-medium">
                    <?= $hive->get('admin.dice_meaning') ?>
                </h3>

                <div class="grid grid-cols-[repeat(auto-fit,minmax(20rem,1fr))] gap-6">
                    <?php foreach ($themes as $theme) : ?>
                        <div>
                            <h4 class="mb-6 font-medium">
                                <?= $theme->name ?>
                            </h4>
                            <div class="max-w-full prose prose-sm text-foreground">
                                <?= \Markdown::instance()->convert($theme->html); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php end_slot(); ?>

<?php
extract(component_props(
    required: ['match_set'],
    optional: [],
    props: get_defined_vars(),
));
$hive = \Base::instance(); ?>
<?php slot('layouts/match-set-layout', [
    'heading' => $hive->get('admin.match_sets'),
    'title' => $hive->get('admin.match_sets')
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $hive->get('admin.match_set')]) ?>

    <div class="space-y-6 max-w-260">

        <ul class='grid gap-2 grid-cols-[repeat(auto-fill,minmax(10rem,1fr))]'>
            <?php foreach ($match_set['images'] as $img) : ?>
                <li class="relative w-full">
                    <?= component('ui/image', [
                        'sizes'    => 'mb',
                        'avif'    => false,
                        'path'     => $img['src'],
                        'prt_class' => 'w-full shrink-0 rounded-xl aspect-2/3 bg-contain!',
                        'img_class' => 'object-contain!',
                    ]) ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.match_set_advice') ?>
            </h3>
            <div>
                <?= $match_set['advice'] ?>
            </div>
        </div>

        <?php if (! empty($match_set['html'])) : ?>
            <div>
                <h3 class="my-15 font-medium">
                    <?= $hive->get('admin.match_set_meaning') ?>
                </h3>
                <div class="max-w-full prose prose-sm">
                    <?= \Markdown::instance()->convert($match_set['html']); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php end_slot(); ?>

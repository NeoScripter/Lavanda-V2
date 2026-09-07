<?php
extract(component_props(
    required: ['match_set'],
    optional: [],
    props: get_defined_vars(),
));
$hive = \Base::instance(); ?>
<?php slot('layouts/match-sets-layout', [
    'heading' => $hive->get('admin.match_sets'),
    'title' => $hive->get('admin.match_sets')
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $match_set['name']]) ?>

    <div class="space-y-6 max-w-160">
        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.match_set_name') ?>
            </h3>
            <div>
                <?= $match_set['name'] ?>
            </div>
        </div>

        <figure class="rounded-sm overflow-clip max-w-48 aspect-2/3">
            <img class="size-full object-contain object-center"
                src="<?= $match_set['front_image']['src'] . "-tb.webp" ?>"
                alt="<?= $match_set['front_image']['alt'] ?>">
        </figure>

        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.match_set_advice') ?>
            </h3>
            <div>
                <?= $match_set['advice'] ?>
            </div>
        </div>

        <?php if (! empty($match_set['description'])) : ?>
            <div>
                <h3 class="my-15 font-medium">
                    <?= $hive->get('admin.match_set_meaning') ?>
                </h3>
                <div class="max-w-full prose prose-sm">
                    <?= \Markdown::instance()->convert($match_set['description']); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php end_slot(); ?>

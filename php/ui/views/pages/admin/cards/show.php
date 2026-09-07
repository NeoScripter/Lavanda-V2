<?php
extract(component_props(
    required: ['card'],
    optional: [],
    props: get_defined_vars(),
));
$hive = \Base::instance(); ?>
<?php slot('layouts/card-grid-layout', [
    'heading' => $hive->get('admin.cards'),
    'title' => $hive->get('admin.cards')
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $card['name']]) ?>

    <div class="space-y-6 max-w-160">
        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.card_name') ?>
            </h3>
            <div>
                <?= $card['name'] ?>
            </div>
        </div>

        <figure class="rounded-sm overflow-clip max-w-48 border border-border shadow-md aspect-2/3">
            <img class="size-full object-contain object-center"
                src="<?= $card['front_image']['src'] . "-tb.webp" ?>"
                alt="<?= $card['front_image']['alt'] ?>">
        </figure>

        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.card_advice') ?>
            </h3>
            <div>
                <?= $card['advice'] ?>
            </div>
        </div>

        <?php if (! empty($card['description'])) : ?>
            <div>
                <h3 class="my-15 font-medium">
                    <?= $hive->get('admin.card_meaning') ?>
                </h3>
                <div class="max-w-full prose prose-sm">
                    <?= \Markdown::instance()->convert($card['description']); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php end_slot(); ?>

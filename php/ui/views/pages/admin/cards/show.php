<?php
extract(component_props(
    required: ['card'],
    optional: [],
    props: get_defined_vars(),
));
$hive = \Base::instance(); ?>
<?php slot('layouts/card-layout', [
    'heading' => $hive->get('admin.cards'),
    'title' => $hive->get('admin.cards')
]);

$src = $card['front_image']['src'] ?? to_public_url(WEBROOT . '/assets/images/cards/empty/empty');
$alt = $card['front_image']['alt'] ?? '';
?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">
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
                <img class="size-full object-cover object-center" src="<?= $src . "-tb.webp" ?>" alt="<?= $alt ?>">
            </figure>

            <div>
                <h3 class="mb-2 font-medium">
                    <?= $hive->get('admin.card_advice') ?>
                </h3>
                <div>
                    <?= $card['advice'] ?>
                </div>
            </div>

            <div>
                <h3 class="my-15 font-medium">
                    <?= $hive->get('admin.card_meaning') ?>
                </h3>
                <div class="max-w-full prose prose-sm">
                    <?= \Markdown::instance()->convert($card['html']); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php end_slot(); ?>

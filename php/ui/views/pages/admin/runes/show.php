<?php

extract(component_props(
    required: ['rune', 'themes'],
    optional: [],
    props: get_defined_vars(),
));
$hive = \Base::instance(); ?>
<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.runes'),
    'title' => $hive->get('admin.runes')
]);

$fallback = to_public_url(WEBROOT . '/assets/images/shared/empty/empty');
$front_img_src = $rune['front_image']['src'] ?? $fallback;
$front_img_alt = $rune['front_image']['alt'] ?? '';
$back_img_src = $rune['back_image']['src'] ?? $fallback;
$back_img_alt = $rune['back_image']['alt'] ?? '';
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $rune['name']]) ?>

    <div class="space-y-10">
        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.rune_name') ?>
            </h3>
            <div>
                <?= $rune['name'] ?>
            </div>
        </div>

        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.rune_images') ?>
            </h3>
            <div class="flex flex-wrap items-center gap-4">
                <figure class="rounded-sm overflow-clip max-w-48 border border-border shadow-md aspect-2/3">
                    <img class="size-full object-cover object-center" src="<?= $front_img_src . "-tb.webp" ?>" alt="<?= $front_img_alt ?>">
                </figure>
                <figure class="rounded-sm overflow-clip max-w-48 border border-border shadow-md aspect-2/3">
                    <img class="size-full object-cover object-center" src="<?= $back_img_src . "-tb.webp" ?>" alt="<?= $back_img_alt ?>">
                </figure>
            </div>
        </div>

        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.rune_advice') ?>
            </h3>
            <div>
                <?= $rune['advice'] ?>
            </div>
        </div>

        <?php if (!empty($themes)) : ?>
            <div>
                <h3 class="my-6 font-medium">
                    <?= $hive->get('admin.rune_meaning') ?>
                </h3>

                <div class="grid grid-cols-[repeat(auto-fit,minmax(20rem,1fr))] gap-6">
                    <?php foreach ($themes as $theme) : ?>
                        <div>
                            <h4 class="mb-6 font-medium">
                                <?= $theme->name ?>
                            </h4>
                            <div class="max-w-full prose prose-sm">
                                <?= \Markdown::instance()->convert($theme->html); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php end_slot(); ?>

<?php

use Enums\RuneTheme;

$hive = \Base::instance();
$path = $hive->PATH;

extract(component_props(
    required: ['heading', 'title', 'rune', 'themes'],
    optional: ['slot' => ''],
    props: get_defined_vars(),
));

slot('layouts/admin-layout', compact('heading', 'title')); ?>

<div class="px-4 py-6">
    <div class="flex flex-col space-y-8 xl:flex-row lg:space-y-0 lg:space-x-12">
        <aside class="w-full max-w-xl lg:w-48">
            <?php slot('components/ui/auth-button', [
                'size'    => 'sm',
                'variant' => 'ghost',
                'attrs'   => ['tabindex' => '-1'],
                'class'   => 'relative w-full justify-start' . ($hive->alias('admin_runes_edit', ['id' => $rune['id']]) === $hive->PATH ? ' bg-muted' : ''),
            ]); ?>
            <a href="<?= $hive->alias('admin_runes_edit', ['id' => $rune['id']]) ?>" class="absolute inset-0 z-10"></a>
            <?= $hive->get('admin.rune') ?>
            <?php end_slot(); ?>

            <?= component('ui/heading', [
                'title'       => $hive->get('admin.categories'),
                'description' => $hive->get('admin.select_a_rune_category'),
                'class' => '!my-5 ml-1'
            ]) ?>

            <nav class="flex flex-col space-y-1 space-x-0">
                <?php foreach ($themes as $theme): ?>
                    <?php $is_current_route = $hive->alias('admin_rune_themes_edit', ['theme_id' => $theme->id]) === $hive->PATH; ?>
                    <?php slot('components/ui/auth-button', [
                        'size'    => 'sm',
                        'variant' => 'ghost',
                        'attrs'   => ['tabindex' => '-1'],
                        'class'   => 'relative w-full justify-start' . ($is_current_route ? ' bg-muted' : ''),
                    ]); ?>
                    <a href="<?= $hive->alias('admin_rune_themes_edit', ['theme_id' => $theme->id]) ?>" class="absolute inset-0 z-10"></a>
                    <?= RuneTheme::from($theme->name)->label() ?>
                    <?php end_slot(); ?>
                <?php endforeach ?>
            </nav>
        </aside>

        <hr class="my-6 xl:hidden">

        <div class="flex-1">
            <section>
                <?= $slot ?>
            </section>
        </div>
    </div>
</div>

<?php end_slot(); ?>

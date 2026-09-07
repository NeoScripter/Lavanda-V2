<?php

use Enums\MatcheableType;
use Enums\SessionKey;

$hive = \Base::instance();
$path = $hive->PATH;

extract(component_props(
    required: ['heading', 'title'],
    optional: ['slot' => ''],
    props: get_defined_vars(),
));

$mt_type = $hive->get('SESSION.' . SessionKey::MATCHEABLE_TYPE->value);
$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);

$nav_items = array_map(
    fn($value) => ['matcheable_type' => $value, 'title' => $hive->get("admin.{$value}")],
    MatcheableType::values()
);

slot('layouts/admin-layout', compact('heading', 'title')); ?>

<div class="flex flex-col space-y-8 xl:flex-row lg:space-y-0 lg:space-x-12">
    <aside class="w-full max-w-xl lg:w-48">
        <?= component('ui/heading', [
            'title'       => $hive->get('admin.match_sets'),
            'description' => $hive->get('admin.select_match_set_category'),
        ]) ?>

        <nav class="flex flex-col space-y-1 space-x-0">
            <?php foreach ($nav_items as $item): ?>
                <?php slot('components/ui/auth-button', [
                    'size'    => 'sm',
                    'variant' => 'ghost',
                    'attrs'   => ['tabindex' => '-1'],
                    'class'   => 'relative w-full justify-start' . ($mt_type === $item['matcheable_type'] ? ' bg-muted' : ''),
                ]); ?>

                <a href="<?= $hive->alias('admin_match_sets_index', [], ['matcheable_type' => $item['matcheable_type']]) ?>"
                    class="absolute inset-0 z-10"></a>

                <?= $item['title'] ?>
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

<?php end_slot(); ?>

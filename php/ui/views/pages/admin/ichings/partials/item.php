<?php $hive = \Base::instance(); ?>
<?php
$mask_map = [
    1 => 1,
    2 => 2,
    3 => 4,
    4 => 8,
    5 => 16,
    6 => 32,
];
extract(component_props(
    required: ['iching'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="space-y-6 relative text-sm">
    <a
        href="<?= $hive->alias('admin_ichings_edit', ['id' => $iching->id]) ?>"
        class='absolute inset-0'>
    </a>
    <h3 class="mb-2 font-bold"><?= $iching->number ?></h3>
    <div class='flex items-center rounded-md justify-around flex-col p-3 bg-accent-foreground size-20'>
        <?php for ($i = 6; $i > 0; $i--) : ?>
            <?php $is_split = ($mask_map[$i] & $iching->bitmask) === 0; ?>
            <div class="flex overflow-hidden w-full items-center justify-center <?= $is_split ? 'gap-4' : '' ?>">
                <?= svg('iching-line') ?>
                <?= svg('iching-line') ?>
            </div>
        <?php endfor; ?>
    </div>
</li>

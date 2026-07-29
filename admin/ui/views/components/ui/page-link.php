<?php
$is_active = $current_page === $to;
$is_leftmost = $to === 0;
$is_rightmost = $to === $total + 1;
$is_edge = $is_rightmost || $is_leftmost;
$is_regular = !$is_active && !$is_edge;
$is_disabled =
    ($is_leftmost && $current_page === 1) ||
    ($is_rightmost && $current_page === $total);

if ($is_leftmost) $to = $current_page - 1;
if ($is_rightmost) $to = $current_page + 1;

// $hive = \Base::instance();
// $url = $hive->PATH . '?' . http_build_query(['page' => $to]);
$hive = \Base::instance();
$url = $hive->alias($hive->ALIAS, $hive->PARAMS, ['page' => $to]);

$class = implode(' ', array_filter([
    'relative hidden size-10 items-center justify-center rounded-sm text-xl font-medium ring-1 transition duration-200 ease-in ring-inset sm:inline-flex sm:size-10',
    $is_active   ? 'text-background ring-muted-foreground bg-foreground' : '',
    $is_regular  ? 'text-foreground ring-inherit hover:scale-110' : '',
    $is_disabled ? 'pointer-forbidden pointer-events-none opacity-50' : '',
    $is_edge     ? 'inline-flex' : '',
    $class ?? '',
]));
?>
<a href="<?= $url ?>" class="<?= $class ?>">
    <?php if ($is_edge): ?>
        <span class="text-foreground size-8 <?= $is_leftmost ? 'rotate-180' : '' ?>">
            <?= svg('chevron-right') ?>
        </span>
    <?php else: ?>
        <?= $to ?>
    <?php endif ?>
</a>

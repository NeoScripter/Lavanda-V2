<?php
// $page is the result of Cortex's ->paginate()
// [pos] is 0-based, so current_page is pos + 1
extract(component_props(
    required: ['page'],
    optional: ['class' => ''],
    props: get_defined_vars(),
));

$current_page = $page['pos'] + 1;
$last_page    = $page['count'];
?>
<?php if ($last_page !== 1) : ?>

    <div class="flex items-center justify-center sm:justify-start py-7 sm:py-10 xl:py-14 <?= $class ?>">
        <nav
            aria-label="Pagination"
            class="isolate flex items-center gap-10 sm:gap-3 w-fit">
            <?php foreach (range(0, $last_page + 1) as $to): ?>
                <?= component('ui/page-link', [
                    'to'           => $to,
                    'current_page' => $current_page,
                    'total'        => $last_page,
                ]) ?>
            <?php endforeach ?>
        </nav>
    </div>
<?php endif; ?>

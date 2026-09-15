<?php

extract(component_props(
    required: ['label', 'url'],
    optional: ['class' => '', 'icon' => null],
    props: get_defined_vars(),
));

$hive = \Base::instance();

$current_route = $hive->PATH . '?' . $hive->QUERY;
$active = $current_route === $url || ($url !== '/admin' && str_contains($current_route, $url));

$link_class = trim(implode(' ', array_filter([
    'active:bg-sidebar-accent hover:bg-sidebar-accent ease my-0.5 flex items-center rounded-sm transition-colors duration-200 mx-1 gap-2 px-3 py-2',
    $active ? 'bg-sidebar-accent' : '',
    $class,
])));
?>
<li>
    <a href="<?= $url ?>" class="<?= $link_class ?>">
        <?= $icon ? svg($icon) : '' ?>
        <span class="ease overflow-x-clip whitespace-nowrap transition-[max-width] duration-300 max-w-64">
            <?= $label ?>
        </span>
    </a>
</li>

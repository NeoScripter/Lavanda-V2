<?php

extract(component_props(
    required: ['slot'],
    optional: ['variant' => 'primary', 'size' => 'md', 'href' => null, 'class' => '', 'attrs' => []],
    props: get_defined_vars(),
));


$variant_classes = [
    'primary'     => 'bg-primary shine outline-background outline-1 text-background hover:scale-104 focus-visible:scale-104',
    'accent'   => 'bg-linear-(--bg-golden) shine text-foregound hover:scale-104 focus-visible:scale-104',
    'outline'     => 'outline-background outline-1 text-primary hover:bg-primary hover:text-background',
];

$size_classes = [
    'sm'    => "px-[1em] has-[>svg]:pr-6 text-sm lg:text-base",
    'md'    => "has-[>svg]:pr-7.5 text-base lg:text-lg",
    'lg'    => "has-[>svg]:pr-8.5 text-lg lg:text-xl",
    'icon'  => 'size-9 rounded-lg',
];

$base = 'flex items-center px-[1.5em] py-[0.9em] justify-center cursor-pointer gap-[0.5em] whitespace-nowrap rounded-full leading-[100%] transition-[color,background-color,box-shadow,scale] shadow-primary hover:shadow-accent'
    . ' disabled:pointer-events-none disabled:opacity-50 disabled:cursor-default'
    . " [&_svg]:pointer-events-none [&_svg]:size-[1.25em] [&_svg]:shrink-0";

$final_class = trim(implode(
    ' ',
    array_filter([
        $base,
        $variant_classes[$variant],
        $size_classes[$size],
        $class,
    ])
));

$tag = $href ? 'a' : 'button';

$attr_string = serialize_attrs($attrs);
if ($href) {
    $attr_string .= " href=\"$href\"";
}
?>
<<?= $tag ?> class="<?= $final_class ?>" <?= $attr_string ?>>
    <?= $slot ?? '' ?>
</<?= $tag ?>>

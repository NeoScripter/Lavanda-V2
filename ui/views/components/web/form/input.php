<?php

$class = $class ?? '';
$attrs = $attrs ?? [];

$base = 'border-foreground selection:bg-primary-pale/50 flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-sm shadow-xs transition-[border,color,box-shadow] outline-none disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm'
    . ' focus-visible:border-primary/50 focus-visible:ring-primary-pale/50 focus-visible:ring-[3px]'
    . ' aria-invalid:border-destructive aria-invalid:ring-destructive/20';

$final_class = trim("$base $class");

$attr_string = serialize_attrs($attrs);
?>
<input data-slot="input" class="<?= $final_class ?>" <?= $attr_string ?>>

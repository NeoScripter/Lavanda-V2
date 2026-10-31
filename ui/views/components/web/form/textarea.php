<?php

$class = $class ?? '';
$slot  = $slot  ?? '';
$attrs = $attrs ?? [];

$base = 'border-foreground selection:bg-primary-pale/50 selection:text-primary-foreground file:text-foreground flex field-sizing-content min-h-30 w-full min-w-0 resize-none rounded-md border bg-transparent px-3 py-1 text-sm shadow-xs transition-[color,box-shadow] outline-none file:inline-flex disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-visible:border-primary/50 focus-visible:ring-primary-pale/50 focus-visible:ring-[3px] aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40';

$final_class = trim("$base $class");

$attr_string = serialize_attrs($attrs);
?>
<textarea data-slot="textarea" class="<?= $final_class ?>" <?= $attr_string ?>><?= $slot ?></textarea>

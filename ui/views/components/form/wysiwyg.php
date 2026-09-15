<?php

extract(component_props(
    required: ['name', 'required', 'id'],
    optional: ['class' => '', 'value' => ''],
    props: get_defined_vars(),
));

$required  = json_encode((bool) ($required  ?? ''));

$base = 'border-input selection:bg-primary selection:text-primary-foreground file:text-foreground placeholder:text-muted-foreground flex field-sizing-content min-h-100 w-full min-w-0 resize-none rounded-md border bg-transparent overflow-clip text-sm shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40';

$final_class = trim("$base $class");
?>
<div component-wysiwyg-editor
    data-required="<?= $required ?>"
    data-name="<?= $name ?>"
    data-id="<?= $id ?>"
    class="<?= $final_class ?>"><?= $value ?></div>

<?php
extract(component_props(
    required: ['url', 'label'],
    optional: ['class' => ''],
    props: get_defined_vars(),
));
?>

<a
    href="<?= $url ?>"
    target="_blank"
    class="font-medium block transition-colors hover:text-muted-foreground hover:motion-safe:animate-jump <?= $class ?>">
    <span class="translate-y-[0.25em] mr-[0.25em] size-[1.25em] inline-block">
        <?php include(APP_DIR . '/public/assets/svgs/download-file.svg'); ?>
    </span>
    <?= $label ?>
</a>

<?php
extract(component_props(
    required: ['url', 'label'],
    optional: ['class' => ''],
    props: get_defined_vars(),
));

$is_audio = str_ends_with($url, 'mp3');
?>

<a
    component-file-link
    href="<?= $url ?>"
    target="_blank"
    class="font-medium block border border-foreground w-fit pl-[0.75em] pr-[1.25em] py-[0.25em] focus-visible:bg-primary-muted hover:bg-primary-muted rounded-sm transition-colors focus-visible:text-white hover:text-white <?= $class ?>">
    <span class="translate-y-[0.25em] mr-[0.25em] size-[1.25em] inline-block">
        <?php svg('download') ;?>
    </span>
    <?= $label ?>
</a>

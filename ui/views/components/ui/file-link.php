<?php
extract(component_props(
    required: ['url', 'label'],
    optional: ['class' => ''],
    props: get_defined_vars(),
));

$is_audio = str_ends_with($url, 'mp3');
?>

<a
    href="<?= $url ?>"
    target="_blank"
    class="font-medium block transition-colors hover:text-muted-foreground hover:motion-safe:animate-jump <?= $class ?>">
    <span class="translate-y-[0.25em] mr-[0.25em] size-[1.25em] inline-block">
        <?php $is_audio ? svg('music') : svg('download-file') ;?>
    </span>
    <?= $label ?>
</a>

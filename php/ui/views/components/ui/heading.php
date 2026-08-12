<?php
extract(component_props(
    required: [],
    optional: ['title' => '', 'class' => '', 'description' => ''],
    props: get_defined_vars(),
));

$final_class = trim('mb-8 space-y-0.5 ' . $class);
?>
<div class="<?= $final_class ?>">
    <h2 class="text-xl font-semibold tracking-tight hyphens-auto">
        <?= $title ?>
    </h2>
    <?php if ($description): ?>
        <p class="text-muted-foreground text-sm">
            <?= $description ?>
        </p>
    <?php endif ?>
</div>

<?php

extract(component_props(
    required: [],
    optional: ['title' => '', 'description' => null, 'class' => ''],
    props: get_defined_vars(),
));

?>
<header class="<?= $class ?>">
    <h3 class="mb-0.5 text-base font-medium hyphens-auto">
        <?= $title ?>
    </h3>
    <?php if ($description): ?>
        <p class="text-muted-foreground text-sm">
            <?= $description ?>
        </p>
    <?php endif ?>
</header>

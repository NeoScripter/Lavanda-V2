<?php

use Enums\LegalSlug;

$hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['legal'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm max-w-md">
    <div class="flex flex-col gap-4 relative">

        <h3 class="mb-2"><?= LegalSlug::from($legal['slug'])->getLabel() ?></h3>

        <p><?= mb_substr($legal['html'], 0, 320) . '...' ?></p>
        <a href="<?= $hive->alias("admin_legals_edit", ['id' => $legal['id']]) ?>"
            class="absolute inset-0">
        </a>
    </div>

    <hr />
</li>

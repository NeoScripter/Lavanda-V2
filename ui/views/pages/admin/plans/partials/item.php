<?php

use Enums\PlanSlug;

 $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['plan'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm transition-shadow hover:shadow-md border border-foreground/50 rounded-sm p-4 relative">
    <div class="flex justify-between items-center gap-3">
        <div class="flex flex-col gap-3">
            <h3 class="font-bold"><?= PlanSlug::from($plan->slug)->label() ?></h3>
            <div class='max-h-15 overflow-clip'><?= $plan->price ?></div>
        </div>

        <figure class='size-5 shrink-0'>
            <?= svg('pencil') ?>
        </figure>
        <a href="<?= $hive->alias("admin_plans_edit", ['id' => $plan->id]) ?>" class="absolute inset-0"></a>

    </div>
</li>

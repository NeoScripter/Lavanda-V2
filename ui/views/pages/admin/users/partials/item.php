<?php

 $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['user'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm border-b border-foreground/50 py-4 relative">
    <div class="flex justify-between items-center gap-3">
        <div class="flex flex-col gap-2">
            <h3 class="font-bold"><?= $user['name'] ?></h3>
            <div class='max-h-15 overflow-clip'><?= $user['email'] ?></div>
        </div>

        <figure class='size-5 shrink-0'>
            <?= svg('pencil') ?>
        </figure>
        <a href="<?= $hive->alias("admin_users_edit", ['id' => $user['id']]) ?>" class="absolute inset-0"></a>

    </div>
</li>

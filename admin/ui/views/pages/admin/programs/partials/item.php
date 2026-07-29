<?php $hive = \Base::instance(); ?>

<li class="grid max-w-140 gap-6 text-sm border border-accent-background rounded-sm">
    <div class="flex flex-col gap-6">

        <div class="relative shadow-md py-2 px-4 rounded-sm hover:animate-jump">
            <h3 class="font-medium"><?= $program->title ?></h3>
            <a href="<?= $hive->alias('admin_programs_edit', ['id' => $program->id]) ?>" class="absolute inset-0 size-full block"></a>
        </div>
    </div>
</li>

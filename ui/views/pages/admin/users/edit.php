<?php

use Enums\PlanSlug;

extract(component_props(
    required: ['user', 'plans'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/admin/item-layout', [
    'heading' => $hive->get('admin.users'),
    'title' => $hive->get('admin.users'),
]); ?>

<div class="space-y-6 max-w-100">
    <div class="flex items-center justify-between gap-4">
        <?= component('admin/ui/subheading', ['title' => $hive->get('admin.user') . ' ' . $user['name']]) ?>
    </div>

    <div class="flex flex-col gap-2">
        <h3 class="font-bold"><?= $user['name'] ?></h3>
        <div class='max-h-15 overflow-clip'><?= $user['email'] ?></div>
    </div>

    <ul class='space-y-2'>
        <h3 class="font-bold"><?= $hive->get('admin.plans') ?>:</h3>
        <?php foreach ($plans as $plan) : ?>
            <li><?= $plan ?></li>
        <?php endforeach; ?>
    </ul>

    <div class='flex items-start flex-col gap-3'>
        <?php foreach (PlanSlug::values() as $slug) : ?>
            <dialog id="<?= 'give-access-dialog-' . $slug ?>" popover class='border border-primary p-4 rounded-sm relative max-w-80'>
                <p class='text-base'>
                    <?= $hive->get('admin.are_you_sure_you_want_to_give_a_subscription_to_this_user') ?>
                </p>
                <div class='flex items-center justify-center gap-6 mt-3'>
                    <form action="<?= $hive->alias('admin_users_update', ['id' => $user['id']]) ?>" method='post'>
                        <?= csrf() ?>
                        <input type="hidden" name="_method" value="put">
                        <input type="hidden" name="slug" value="<?= $slug ?>">

                        <?= component('admin/ui/auth-button', [
                            'size' => 'sm',
                            'variant' => 'destructive',
                            'class' => 'min-w-20',
                            'slot' => $hive->get("admin.yes"),
                            'attrs' => ['type' => 'submit']
                        ]) ?>
                    </form>
                    <button popovertarget="<?= 'give-access-dialog-' . $slug ?>" popovertargetaction="hide" class='cursor-pointer min-w-25 transition-colors hover:text-primary'>
                        <span class='block size-6'><?= $hive->get("admin.cancel") ?>
                        </span>
                    </button>
                </div>
            </dialog>
            <button popovertarget="<?= 'give-access-dialog-' . $slug ?>" class='flex text-foreground transition-opacity hover:opacity-80 items-center justify-center gap-[1em]'>
                <span class='*:size-[1.25em]'> <?= svg('gift') ?> </span>
                <span class='block max-w-80 text-left'>

                    <?= match ($slug) {
                        PlanSlug::MONTHLY->value => $hive->get('admin.дать_подписку_на_месяц'),
                        PlanSlug::YEARLY->value => $hive->get('admin.дать_подписку_на_год'),
                        PlanSlug::PERSONAL->value => $hive->get('admin.подарить_персональную_консультацию'),
                        PlanSlug::ONE_TIME->value => $hive->get('admin.подарить_три_игры'),
                    }
                    ?>
                </span>

            </button>

        <?php endforeach; ?>

    </div>

</div>

<?php end_slot(); ?>

<?php

$hive = \Base::instance();

extract(component_props(
    required: ['users'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/admin/item-layout', [
    'heading' => $hive->get('admin.users'),
    'title' => $hive->get('admin.users')
]); ?>

<p class='mb-2'><?= count($users) ?> <?= mb_strtolower($hive->get('admin.пользователей')) ?></p>

<div class="space-y-8 w-[calc(100%-1rem)]">
    <?php if (! empty($users)) : ?>
        <ul class="grid gap-6 max-w-sm">

            <?php foreach ($users as $user) : ?>
                <?php view('pages/admin/users/partials/item', [
                    'user' => $user,
                ]); ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_users_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>

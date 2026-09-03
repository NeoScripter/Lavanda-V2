<?php

use Enums\SessionKey;

$hive = \Base::instance();
$path = $hive->PATH;

extract(component_props(
    required: ['heading', 'title', 'topics'],
    optional: ['slot' => ''],
    props: get_defined_vars(),
));

$selected_topic = $hive->get('SESSION.' . SessionKey::AFFIRMATION_TOPIC->value);
$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);

slot('layouts/admin-layout', compact('heading', 'title')); ?>

<div class="flex flex-col space-y-8 xl:flex-row lg:space-y-0 lg:space-x-12">
    <aside class="w-full max-w-xl lg:w-48">
        <?= component('ui/heading', [
            'title'       => $hive->get('admin.affirmations'),
            'description' => $hive->get('admin.select_category'),
        ]) ?>

        <nav class="flex flex-col space-y-1 space-x-0">
            <?php if (!empty($topics)) : ?>

                <?php foreach ($topics as $topic): ?>
                    <?php slot('components/ui/auth-button', [
                        'size'    => 'sm',
                        'variant' => 'ghost',
                        'attrs'   => ['tabindex' => '-1'],
                        'class'   => 'relative w-full justify-start' . ($selected_topic === $topic ? ' bg-muted' : ''),
                    ]); ?>

                    <a href="<?= $hive->alias('admin_affirmations_index', [], ['topic' => urlencode($topic)]) ?>"
                        class="absolute inset-0 z-10"></a>

                    <?= $topic ?>
                    <?php end_slot(); ?>
                <?php endforeach ?>
            <?php else: ?>
                <p class='text-xs'><?= $hive->get('admin.no_categories') ?></p>
            <?php endif; ?>
        </nav>
    </aside>

    <hr class="my-6 xl:hidden">

    <div class="flex-1">
        <section>
            <?= $slot ?>
        </section>
    </div>
</div>

<?php end_slot(); ?>

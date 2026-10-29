<?php

use Enums\Locale;
use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['category'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php if ($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) !== Locale::RUSSIAN->value) : ?>
    <dialog id="clone-model-dialog" popover class='border border-primary p-4 rounded-sm relative max-w-80'>
        <p class='text-base'>
            <?= $hive->get('admin.are_you_sure_you_want_to_clone_these_entities_from_the_russian_version') ?>
        </p>
        <div class='flex items-center justify-center gap-6 mt-3'>
            <form action="<?= $hive->alias('admin_model_clone') ?>" method="post">
                <input type="hidden" name="category" value="<?= $category ?>">
                <?= csrf() ?>

                <?= component('web/ui/button', [
                    'size' => 'sm',
                    'variant' => 'danger',
                    'slot' => $hive->get("admin.clone"),
                    'attrs' => ['type' => 'submit']
                ]) ?>
            </form>
            <button popovertarget="clone-model-dialog" popovertargetaction="hide" class='cursor-pointer min-w-25 transition-colors hover:text-primary'>
                <span class='block size-6'><?= $hive->get("admin.cancel") ?>
                </span>
            </button>
        </div>
    </dialog>
    <button popovertarget="clone-model-dialog" class='flex text-foreground transition-opacity hover:opacity-80 items-center justify-center gap-[1em]'>
        <span class='*:size-[1.25em]'> <?= svg('clone') ?> </span>
        <span class='block max-w-40 text-left'><?= $hive->get("admin.copy_from_russian_entries") ?></span>

    </button>
<?php endif; ?>

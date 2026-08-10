<?php
$class = $class ?? '';
$hive = \Base::instance();

$final_class = trim('inline-flex gap-1 rounded-lg bg-neutral-100 p-1 dark:bg-neutral-800 ' . $class);

$tabs = [
    [
        'value' => 'ru',
        'label' => 'Russian',
        'icon'  => 'ru',
    ],
    [
        'value' => 'en',
        'label' => 'English',
        'icon'  => 'en',
    ],
];
?>
<div class="<?= $final_class ?>">

    <?php foreach ($tabs as $tab): ?>
        <form
            action="<?= $hive->alias('locale_update') ?>"
            method="post">
            <?= csrf() ?>

            <input type="hidden" name='locale' value="<?= $tab['value'] ?>" />
            <button
                type="submit"
                data-lang="<?= $tab['value'] ?>"
                class="flex items-center rounded-md px-3.5 py-1.5 transition-colors text-neutral-500 
                <?= str_starts_with($hive->get('LANGUAGE'), $tab['value']) ?
                    'bg-white shadow-xs dark:bg-neutral-700 dark:text-neutral-100'
                    : 'hover:bg-neutral-200/60 hover:text-black dark:text-neutral-400 dark:hover:bg-neutral-700/60' ?>">
                <span class='size-5'><?= svg($tab['icon']) ?></span>
                <span class="ml-1.5 text-sm"><?= $tab['label'] ?></span>
            </button>
        </form>
    <?php endforeach ?>
</div>

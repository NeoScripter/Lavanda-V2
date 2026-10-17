<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: [],
    optional: ['diceable_id' => ''],
    props: get_defined_vars(),
));

$error = \Flash::instance()->getKey("errors.diceable_id") ?? '';

$dices = require(APP_DIR . '/ui/data/models/dices.php');

$selected_ids = explode('|', $diceable_id);
$selected_dices = array_filter(
    $dices,
    fn($dice) => in_array($dice['id'], $selected_ids)
);
?>

<div cmp-dice-picker>
    <h3 class='mb-2 font-medium'>
        <?= $hive->get('admin.select_items_for_the_dice') ?>
    </h3>

    <input name="diceable_id" type='hidden' value="<?= $diceable_id ?>" />

    <template cmp-selected-img-template>
        <li data-imgbl-id=""
            class='relative group'>

            <figure class='aspect-square w-full'>
                <img src=""
                    class='size-full object-contain object-center' />
            </figure>

            <button cmp-deselect-dice-btn
                type="button"
                class='absolute right-0 top-0 size-8 bg-destructive transition-colors rounded-sm text-background group-hover:bg-destructive/80'>
                <?= svg('x') ?>
            </button>
        </li>
    </template>

    <div>
        <ul cmp-available-dices
            class='grid grid-cols-[repeat(auto-fill,minmax(6rem,1fr))] gap-2'>

            <?php foreach ($dices as $dice) : ?>

                <li data-imgbl-id="<?= $dice['id'] ?>"
                    class='relative transition-transform hover:scale-110 hover:z-1 group'>

                    <figure class='aspect-square w-full'>
                        <img src="<?= $dice['image'] . '-mb.webp' ?>"
                            alt="<?= $dice['meaning'] ?>"
                            class='size-full object-contain object-center' />
                    </figure>


                    <button cmp-select-dice-btn
                        type="button"
                        class='absolute inset-0 bg-black/30 transition-opacity opacity-0 group-hover:opacity-100'>

                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <ul cmp-selected-dices
            class='grid grid-cols-[repeat(auto-fill,minmax(8rem,1fr))] gap-2 has-[li]:mt-8'>
            <?php foreach ($selected_dices as $selected_dice) : ?>

                <li data-imgbl-id="<?= $selected_dice['id'] ?>"
                    class='relative group'>

                    <figure class='aspect-square w-full'>
                        <img src="<?= $selected_dice['image'] . '-mb.webp' ?>"
                            alt="<?= $selected_dice['meaning'] ?>"
                            class='size-full object-contain object-center' />
                    </figure>

                    <button cmp-deselect-dice-btn
                        type="button"
                        class='absolute right-0 top-0 size-8 bg-destructive transition-colors rounded-sm text-background group-hover:bg-destructive/80'>
                        <?= svg('x') ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?= component('admin/form/input-error', [
        'message' => $error,
        'class' => 'mt-2'
    ]) ?>
</div>

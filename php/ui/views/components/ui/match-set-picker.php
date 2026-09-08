<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['images'],
    optional: ['matcheable_id' => ''],
    props: get_defined_vars(),
));

$error = \Flash::instance()->getKey("errors.ids") ?? '';

$selected_ids = explode('|', $matcheable_id);
$selected_imgs = array_filter(
    $images->castAll(),
    fn($img) => in_array($img['imageable_id'], $selected_ids)
);
?>

<div component-match-set-picker>
    <h3 class='mb-2 font-medium'>
        <?= $hive->get('admin.select_items_for_the_set') ?>
    </h3>

    <input name="ids" type='hidden' value="<?= $matcheable_id ?>" />

    <template component-selected-img-template>
        <li data-imgbl-id=""
            class='relative group'>

            <figure class='aspect-2/3 w-full'>
                <img src=""
                    class='size-full object-contain object-center' />
            </figure>

            <button component-deselect-set-btn
                type="button"
                class='absolute right-0 top-0 size-8 bg-destructive transition-colors rounded-sm text-background group-hover:bg-destructive/80'>
                <?= svg('x') ?>
            </button>
        </li>
    </template>

    <?php if (empty($images)) : ?>
        <p>There are no items created</p>
    <?php else : ?>
        <div>
            <ul component-available-sets
                class='grid grid-cols-[repeat(auto-fill,minmax(2rem,1fr))] gap-2'>

                <?php foreach ($images as $img) : ?>

                    <li data-imgbl-id="<?= $img->imageable_id ?>"
                        class='relative transition-transform hover:scale-150 hover:z-1 group'>

                        <figure class='aspect-2/3 w-full'>
                            <img src="<?= $img['src'] . '-mb.webp' ?>"
                                alt="<?= $img['alt'] ?>"
                                class='size-full object-contain object-center' />
                        </figure>


                        <button component-select-set-btn
                            type="button"
                            class='absolute inset-0 bg-black/30 transition-opacity opacity-0 group-hover:opacity-100'>

                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <ul component-selected-sets
                class='grid grid-cols-[repeat(auto-fill,minmax(8rem,1fr))] gap-2 has-[li]:mt-8'>
                <?php foreach ($selected_imgs as $selected_img) : ?>

                    <li data-imgbl-id="<?= $selected_img->imageable_id ?>"
                        class='relative group'>

                        <figure class='aspect-2/3 w-full'>
                            <img src="<?= $selected_img['src'] . '-mb.webp' ?>"
                                alt="<?= $selected_img['alt'] ?>"
                                class='size-full object-contain object-center' />
                        </figure>

                        <button component-deselect-set-btn
                            type="button"
                            class='absolute right-0 top-0 size-8 bg-destructive transition-colors rounded-sm text-background group-hover:bg-destructive/80'>
                            <?= svg('x') ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?= component('form/input-error', ['message' => $error]) ?>
</div>

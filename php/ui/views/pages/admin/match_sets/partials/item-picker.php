<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['images'],
    optional: ['selected_ids' => []],
    props: get_defined_vars(),
));
?>

<div>
    <h3 class='mb-2 font-medium'>Выберите элементы для комбинации</h3>

    <ul component-match-set-picker
        class='grid grid-cols-12 gap-2'>

        <input name="ids" type='hidden' value="<?= implode('|', $selected_ids) ?>" />

        <?php foreach ($images as $img) : ?>

            <li class='relative transition-transform hover:scale-105 group'>
                <?= component('ui/image', [
                    'sizes'    => 'mb',
                    'avif'    => false,
                    'path'     => $img->src,
                    'prt_class' => 'w-full shrink-0 bg-contain! aspect-2/3',
                    'img_class' => 'object-contain! object-center!',
                ]) ?>
                <button component-match-set-trigger
                    type="button"
                    class='absolute inset-0 bg-black/30 transition-opacity opacity-0 group-hover:opacity-100'>

                </button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

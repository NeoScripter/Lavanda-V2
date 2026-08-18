<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['flipside'],
    optional: [],
    props: get_defined_vars(),
));

$flipside_modal_id = uniqid('flipside_modal_');
?>

<?php if (! empty($flipside)) : ?>

    <li class="grid gap-6 text-sm">
        <div class="flex flex-col gap-4">

            <div class="relative w-full">
                <?= component('ui/image', [
                    'sizes'    => 'mb',
                    'avif'    => false,
                    'path'     => $flipside['src'],
                    'prt_class' => 'w-full shrink-0 rounded-xl aspect-2/3',
                ]) ?>

            </div>

            <div>
                <h3 class="mb-2 font-bold"><?= $hive->get('admin.flipside') ?></h3>
            </div>

            <div class='flex flex-col justify-start gap-2'>

                <?= component('ui/auth-button', [
                    'variant' => 'primary',
                    'class'   => 'h-9 rounded-sm text-sm',
                    'slot' => $hive->get('admin.edit'),
                    'attrs' => [
                        'component-modal-show' => true,
                        'data-modal-id' => $flipside_modal_id,
                    ]
                ]) ?>


            </div>

            <?php slot('components/layout/modal', ['modal_id' => $flipside_modal_id]); ?>

            <form action="<?= $hive->alias('admin_images_update', ['id' => $flipside['id']]) ?>"
                method="post"
                class="space-y-6 w-120">
                <input type="hidden" name="_method" value="put">
                <?= csrf() ?>

                <?= component('form/form-file-input', [
                    'name'  => 'back_image',
                    'label' => $hive->get('admin.flipside'),
                    'can_delete' => false,
                    'value'    => [$flipside],
                    'attrs' => [
                        'multiple' => false,
                    ],
                ]) ?>


                <div class="flex justify-start gap-3.5">
                    <?= component(
                        'ui/auth-button',
                        ['slot' => $hive->get('admin.save'), 'attrs' => ['type' => 'submit']]
                    ) ?>
                    <?= component(
                        'ui/auth-button',
                        [
                            'slot' => $hive->get('admin.cancel'),
                            'variant' => 'secondary',
                            'attrs' => ['type' => 'button', 'component-modal-dismiss' => true]
                        ]
                    ) ?>
                </div>
            </form>

            <?php end_slot(); ?>
        </div>
    </li>
<?php endif; ?>

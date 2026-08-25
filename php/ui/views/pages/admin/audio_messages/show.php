<?php
extract(component_props(
    required: ['audio'],
    optional: [],
    props: get_defined_vars(),
));
$hive = \Base::instance(); ?>
<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.audios'),
    'title' => $hive->get('admin.audios')
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $hive->get('admin.audio_file')]) ?>

    <div class="space-y-6 max-w-160">
        <div>
            <h3 class="mb-2 font-medium"> <?= $hive->get('admin.description') ?> </h3>
            <p><?= $audio['description'] ?></p>
        </div>

        <div>
            <h3 class="mb-2 font-medium"> <?= $hive->get('admin.file') ?> </h3>
            <?= component('ui/file-link', [
                'label' => extract_file_name($audio['file']),
                'url' => $audio['file']
            ]) ?>
        </div>
    </div>
</div>

<?php end_slot(); ?>

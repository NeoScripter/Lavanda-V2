<?php
extract(component_props(
    required: ['item'],
    optional: [],
    props: get_defined_vars(),
));
$hive = \Base::instance(); ?>
<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.practice'),
    'title' => $hive->get('admin.practice')
]);
?>

<div class="space-y-6">
    <?= component('ui/subheading', ['title' => $item['title']]) ?>

    <div class="space-y-6 max-w-160">
        <div>
            <h3 class="mb-2 font-medium">
                <?= $hive->get('admin.item_name') ?>
            </h3>
            <div>
                <?= $item['title'] ?>
            </div>
        </div>

        <figure class="rounded-sm overflow-clip max-w-48 border border-border shadow-md aspect-2/3">
            <img class="size-full object-cover object-center"
                src="<?= $item['image']['src'] . "-tb.webp" ?>"
                alt="<?= $item['image']['alt'] ?>">
        </figure>

        <div>
            <h3 class="mb-2 font-medium"> <?= $hive->get('admin.description') ?> </h3>
            <p><?= $item['description'] ?></p>
        </div>

        <div>
            <h3 class="mb-2 font-medium"> <?= $hive->get('admin.file') ?> </h3>
            <?= component('ui/file-link', [
                'label' => $item['file_src'],
                'url' => $item['file_src']
            ]) ?>
        </div>

        <div>
            <h3 class="mb-3 font-medium"> <?= $hive->get('admin.faqs') ?> </h3>
            <ul class="space-y-4">
                <?php foreach ($item['faqs'] as $faq) : ?>
                    <li>
                        <h4 class='font-bold mb-2 text-lg'> <?= $faq['question'] ?> </h4>
                        <p> <?= $faq['answer'] ?> </p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?php end_slot(); ?>

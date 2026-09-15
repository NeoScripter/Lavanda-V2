<?php $hive = \Base::instance(); ?>
<?php
extract(component_props(
    required: ['faq'],
    optional: [],
    props: get_defined_vars(),
));
?>

<li class="grid gap-6 text-sm transition-shadow hover:shadow-md p-4 relative">
    <div class="flex flex-col gap-3">
        <div>
            <h3 class="mb-2 font-bold"><?= $faq->question ?></h3>
            <article class='max-h-15 overflow-clip'><?= Markdown::instance()->convert($faq->answer) ?></article>
        </div>

        <a href="<?= $hive->alias("admin_faqs_edit", ['id' => $faq->id]) ?>" class="absolute inset-0"></a>

    </div>
</li>

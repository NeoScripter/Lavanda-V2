<?php

extract(component_props(
    required: ['article'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $article->name,
    'class' => "bg-primary-muted/50"
]); ?>

<section class='pt-35 sm:pt-66 lg:pt-56 xl:pt-42'>
    <div class="max-w-full prose md:prose-lg lg:prose-xl xl:prose-2xl [&_h1,h2,h3,h4,h5,strong]:text-primary! [&_hr]:border-primary-muted! [&_li::marker]:text-primary-muted!">
        <?= \Markdown::instance()->convert($article['html']); ?>
    </div>
</section>
<?php end_slot(); ?>

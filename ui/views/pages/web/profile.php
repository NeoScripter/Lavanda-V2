<?php

extract(component_props(
    required: [],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Редактировать профиль',
    'class' => "bg-[url('/assets/images/pages/article/page-bg.webp')] bg-cover bg-center"
]); ?>

<section class='pt-(--pt-lg)'>
    <div class="bg-white">
        hello world
    </div>
</section>
<?php end_slot(); ?>

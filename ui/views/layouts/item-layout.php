<?php
extract(component_props(
    required: ['heading', 'title'],
    optional: ['slot' => ''],
    props: get_defined_vars(),
));

slot('layouts/admin-layout', compact('heading', 'title'));
?>

<section>
    <?= $slot ?>
</section>

<?php end_slot(); ?>

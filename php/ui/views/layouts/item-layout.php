<?php
extract(component_props(
    required: ['heading', 'title'],
    optional: ['slot' => ''],
    props: get_defined_vars(),
));

slot('layouts/admin-layout', compact('heading', 'title'));
?>

<div class="px-6 py-6">
    <section>
        <?= $slot ?>
    </section>
</div>

<?php end_slot(); ?>

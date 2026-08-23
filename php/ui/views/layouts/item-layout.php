<?php
extract(component_props(
    required: [],
    optional: ['slot' => '', 'heading' => '', 'title' => ''],
    props: get_defined_vars(),
));

slot('layouts/admin-layout', compact('heading', 'title'));
?>

<div class="px-4 py-6">
    <div class="flex flex-col space-y-8 xl:flex-row lg:space-y-0 lg:space-x-12">

        <hr class="my-6 xl:hidden">

        <div class="flex-1">
            <section>
                <?= $slot ?>
            </section>
        </div>
    </div>
</div>

<?php end_slot(); ?>

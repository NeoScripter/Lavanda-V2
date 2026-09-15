<?php $hive = \Base::instance(); ?>
<?php slot('layouts/web/app-shell', [
    'heading' => 'hello',
    'title' => 'hello',
]); ?>

<div
    class='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
    <div>Hello world</div>
</div>

<?php end_slot(); ?>

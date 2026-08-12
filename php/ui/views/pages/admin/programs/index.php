<?php slot('layouts/admin-layout', [
    'heading' => 'Programs',
    'title' => 'Programs'
]); ?>


<div class="space-y-6">
    <div class="admin-shell space-y-6">
        <div>
            <?= component('ui/subheading', [
                'title' => "Programs",
            ]) ?>
        </div>

        <?php if (! empty($programs)) : ?>
            <ul class="space-y-8">
                <?php foreach ($programs as $program) : ?>
                    <?php view('pages/admin/programs/partials/item', [
                        'program' => $program,
                    ]); ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?php end_slot(); ?>

<?php slot('layouts/admin-layout', [
    'heading' => 'Reports',
    'title' => 'Reports'
]); ?>

<div class="space-y-6">
    <div class="admin-shell space-y-6">
        <div>
            <?= component('ui/subheading', [
                'title' => "Reports",
            ]) ?>
            <nav class="mb-2 mt-4">
                <?= component('ui/auth-button', [
                    'variant' => 'primary',
                    'class'   => 'h-9 rounded-sm text-sm',
                    'slot' => 'Create New',
                    'href' => \Base::instance()->alias('admin_reports_create'),
                ]) ?>
            </nav>

        </div>

        <?php if (! empty($reports)) : ?>
            <div>
                <p class="mb-8 text-base">Drag a report and drop it onto another report in order to swap them.</p>
                <ul class="space-y-8">
                    <?php foreach ($reports as $report) : ?>
                        <?php view('pages/admin/reports/partials/item', [
                            'report' => $report,
                        ]); ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php end_slot(); ?>

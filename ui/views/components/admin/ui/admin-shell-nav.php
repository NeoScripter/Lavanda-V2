<?php

$href = $href ?? '';
?>
<nav class="mb-2">
    <?php slot('components/admin/ui/auth-button', [
        'href'    => $href,
        'variant' => 'default',
        'class'   => 'h-9 rounded-sm text-sm'
    ]); ?>
    Create New
    <?php end_slot(); ?>
</nav>

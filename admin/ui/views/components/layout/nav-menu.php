<?php
$nav_links = [
    ['url' => '/', 'label' => 'Home'],
    [
        'label' => 'Programs',
        'nav_links' => [
            ['url' => '/programs/education', 'label' => 'Education'],
            ['url' => '/programs/healthcare', 'label' => 'Preventive Healthcare'],
            ['url' => '/programs/economic-development', 'label' => 'Economic Development'],
            // ['url' => '/faqs', 'label' => 'Sustainable Environment and Clean Water'],
            // ['url' => '/history', 'label' => 'Social Mobilization'],
            ['url' => '/programs/disaster', 'label' => 'Disaster Relief'],
        ]
    ],
    ['url' => '/history', 'label' => 'History'],
    ['url' => '/faqs', 'label' => 'FAQs'],
    ['url' => '/memberships', 'label' => 'Memberships'],
    ['url' => '/reports', 'label' => 'Reports'],
    ['url' => '/volunteers', 'label' => 'Volunteers'],
    ['url' => '/newsletters', 'label' => 'Newsletters'],
    ['url' => '/articles', 'label' => 'SRI in the News'],
    // ['url' => '/alliances', 'label' => 'Alliances'],
    // ['url' => '/faqs', 'label' => 'FAQ'],
    ['url' => '/donate', 'label' => 'Donate'],
]; ?>

<nav class="<?= $class ?? '' ?>">
    <ol class="flex flex-col md:flex-row md:flex-wrap md:items-baseline text-lg md:text-base xl:text-lg gap-4 md:gap-8 xl:gap-10 justify-end">
        <?php foreach ($nav_links as $link) : ?>
            <?php view('components/layout/nav-link', $link); ?>
        <?php endforeach; ?>
    </ol>
</nav>

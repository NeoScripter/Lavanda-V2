<!doctype html>
<html lang="en" class="overflow-x-clip">
<?php $hive = \Base::instance(); ?>

<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="<?= '/assets/favicon.svg' ?>" type="image/svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preload" href="/assets/fonts/JTUSjIg1_i6t8kCHKm459W1hyzbi.woff2" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="/assets/fonts/JTUSjIg1_i6t8kCHKm459Wlhyw.woff2" as="font" type="font/woff2" crossorigin />

    <style>
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url('/assets/fonts/JTUSjIg1_i6t8kCHKm459W1hyzbi.woff2') format('woff2');
            unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url('/assets/fonts/JTUSjIg1_i6t8kCHKm459Wlhyw.woff2') format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>

    <?= vite_tags('ui/ts/web.ts') ?>
    <title><?= ($hive->get("web.lavanda")) . (isset($title) ? " - {$title}" : '') ?></title>
</head>

<body class="overflow-x-clip font-sans">
    <div class='relative max-w-480 mx-auto'>
        <div id="app" class="min-h-screen isolate">
            <?= $slot ?? '' ?>
        </div>

        <?= component('web/ui/toast') ?>

        <div id="modals"></div>
    </div>
</body>

</html>

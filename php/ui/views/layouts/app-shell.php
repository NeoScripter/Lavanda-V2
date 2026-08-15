<!doctype html>
<html lang="en" class="overflow-x-clip <?= (\Base::instance()->COOKIE['theme'] ?? '') === 'dark' ? 'dark' : ''  ?>">
<?php $app_url = \Base::instance()->get('app_url'); ?>

<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="<?= $app_url . 'assets/svgs/auth-logo.svg' ?>" type="image/svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link
        rel="preload"
        href="<?= $app_url . 'assets/fonts/UcCo3FwrK3iLTcviYwY.woff2' ?>"
        as="font"
        type="font/woff2"
        crossorigin />
    <link
        rel="preload"
        href="<?= $app_url . 'assets/fonts/UcCo3FwrK3iLTcvmYwYL8g.woff2' ?>"
        as="font"
        type="font/woff2"
        crossorigin />

    <style>
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url("<?= $app_url . 'assets/fonts/UcCo3FwrK3iLTcvmYwYL8g.woff2' ?>") format('woff2');
            unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url("<?= $app_url . 'assets/fonts/UcCo3FwrK3iLTcviYwY.woff2' ?>") format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>

    <style>
        html {
            background-color: oklch(1 0 0);
        }

        html.dark {
            background-color: oklch(0.2435 0 0);
        }
    </style>

    <?= vite_tags('ui/ts/app.ts') ?>
    <title><?= (\Base::instance()->get("admin.admin_panel")) . (isset($title) ? " - {$title}" : '') ?></title>
</head>

<body class="overflow-x-clip font-sans">
    <div id="app" class="min-h-screen isolate">
        <?= $slot ?? '' ?>
    </div>

    <?= component('ui/toast') ?>

    <div id="modals"></div>
</body>

</html>

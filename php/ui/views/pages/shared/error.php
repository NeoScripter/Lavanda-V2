<!doctype html>
<html
    lang="en"
    class="overflow-x-clip">

<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0" />
    <?= vite_tags('ui/ts/app/app.ts') ?>
    <link rel="icon" href="/favicon.webp" type="image/webp">
    <title><?= "Error" . (isset($title) ? " - {$title}" : '') ?></title>

    <style>
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url('/assets/fonts/JTUSjIg1_i6t8kCHKm459Wlhyw.woff2') format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>
</head>

<body class="overflow-x-clip h-screen max-w-480 mx-auto font-mono">
    <main class="grid place-content-center place-items-center h-full uppercase sm:text-xl lg:text-2xl">
        <div class="font-semibold tracking-wide">Oops! An error occured</div>
        <div class="font-black mt-4 mb-6 lg:mt-[0.06em] lg:mb-[0.12em] leading-[0.75em] grid grid-flow-col text-[8rem] sm:text-[14rem] lg:text-[20rem] tracking-[-2rem] text-shadow-[-0.02em_-0.02em_0px_rgba(255,255,255,1)]">
            <span class="translate-x-[30%]"><?= intdiv($code, 100) ?></span>
            <span class="isolate"><?= intdiv($code % 10, 10) ?></span>
            <span class="translate-x-[-30%]"><?= $code % 100 ?></span>
        </div>
        <div class="font-medium tracking-wide max-w-[min(35rem,90%)] text-center text-balance"><?= $message ?? 'error' ?></div>
    </main>
</body>

</html>

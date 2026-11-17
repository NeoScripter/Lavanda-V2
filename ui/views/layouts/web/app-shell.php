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

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })(window, document, 'script', 'https://mc.yandex.ru/metrika/tag.js?id=108181760', 'ym');

        ym(108181760, 'init', {
            ssr: true,
            webvisor: true,
            clickmap: true,
            ecommerce: "dataLayer",
            referrer: document.referrer,
            url: location.href,
            accurateTrackBounce: true,
            trackLinks: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/108181760" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Top.Mail.Ru counter -->
    <script type="text/javascript">
        var _tmr = window._tmr || (window._tmr = []);
        _tmr.push({
            id: "3751451",
            type: "pageView",
            start: (new Date()).getTime()
        });
        (function(d, w, id) {
            if (d.getElementById(id)) return;
            var ts = d.createElement("script");
            ts.type = "text/javascript";
            ts.async = true;
            ts.id = id;
            ts.src = "https://top-fwz1.mail.ru/js/code.js";
            var f = function() {
                var s = d.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(ts, s);
            };
            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "tmr-code");
    </script>
    <noscript>
        <div><img src="https://top-fwz1.mail.ru/counter?id=3751451;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div>
    </noscript>
    <!-- /Top.Mail.Ru counter -->

    <?= vite_tags('ui/ts/web.ts') ?>
    <title><?= ($hive->get("web.lavanda")) . (isset($title) ? " - {$title}" : '') ?></title>
</head>

<body class="overflow-x-clip font-sans">
    <div class='relative max-w-480 mx-auto'>
        <div id="app" class="min-h-screen isolate">
            <?= $slot ?? '' ?>
        </div>

        <?= component('web/ui/toast') ?>

        <?= component('web/ui/notification') ?>

        <div id="modals"></div>
    </div>

    <template cmp-img-template>
        <?= component('shared/ui/image', [
            'sizes'    => 'mb|tb',
            'alt' => "Empty image alt",
            'path'     => '/assets/images/shared/empty/empty',
            'prt_class' => 'bg-contain!',
            'img_class' => 'size-full object-contain! object-center',
        ]) ?>
    </template>

</body>

</html>

<?php
$hive = \Base::instance(); ?>
<div class="bg-nav-background bg-cover bg-no-repeat bg-center text-gray-50 full-bleed sm:justify-around md:z-1000 py-6 xl:py-8 border-t border-gray-50/30 px-(--px) flex flex-col sm:flex-row gap-8" style="background-image: <?= "url(/assets/imgs/shared/bg-hero/background-hero-neutral.webp)" ?>">
    <div class="mx-auto <?= empty($hive->BANNER_CONTENT) ? '' : 'lg:max-w-[85ch]' ?> text-balance uppercase">
        <p>
            <?= $hive->BANNER_CONTENT ??
                '<strong>100%</strong> of donations go directly toward programs for disadvantaged communities. SRI’s board members pay for all overhead costs from their personal funds.' ?>
        </p>
    </div>

    <?php if (empty($hive->BANNER_CONTENT)) : ?>
        <div class="self-center">
            <a href="/donate" class="gradient-button flex items-center justify-center uppercase tracking-widest font-bold leading-[1em]">
                donate
            </a>
        </div>
    <?php endif; ?>
</div>

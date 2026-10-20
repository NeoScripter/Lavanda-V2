<?php extract(component_props(
    required: ['slot'],
    optional: ['title' => '', 'description' => null, 'class' => ''],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $title,
    'class' => "bg-[url('/assets/images/pages/article/page-bg.webp')] bg-cover bg-center"
]); ?>

<section class='pt-(--pt-lg) full-bleed'>
    <div class="<?= cc('bg-white w-full max-w-120 mx-auto xs:rounded-xl sm:rounded-primary px-6 py-9 sm:py-11 sm:px-9', $class) ?>">

        <div class="flex flex-col gap-8">
            <div class="flex flex-col items-center gap-6">
                <a
                    href="/"
                    class="flex flex-col items-center gap-2 font-medium">
                    <figure class='mx-auto w-45 sm:ml-0'>
                        <img src="/assets/svgs/logo-lg-violet.svg" class="size-full object-contain object-center" />
                    </figure>

                    <span class="sr-only"><?= $title ?? '' ?></span>
                </a>

                <div class="space-y-2 text-center">
                    <h1 class="text-xl font-semibold"><?= $title ?? '' ?></h1>
                    <?php if (!empty($description)) : ?>
                        <p class="text-muted-foreground text-center text-sm text-balance">
                            <?= $description ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <?= $slot ?? '' ?>
        </div>
    </div>
</section>
<?php end_slot(); ?>

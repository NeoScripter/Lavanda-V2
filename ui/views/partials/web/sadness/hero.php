<section class='full-bleed [--sq-size:min(20.875rem,90vw)] lg:[--sq-size:25rem] 2xl:[--sq-size:30rem] [--offset:calc(var(--sq-size)/4)] sm:[--offset:calc(var(--sq-size)/2)] mb-(--offset) lg:mb-[calc(var(--offset)-7.75rem)] xl:mb-[calc(var(--offset)-12rem)]'>
    <?php slot('components/web/layout/hero', [
        'class' => "bg-white pb-0 sm:pb-0"
    ]); ?>
    <div class='lg:flex lg:items-start lg:gap-23.25'>
        <div class='space-y-8 md:space-y-12'>
            <h1 class='mb-2 text-left'>Мне грустно</h1>

            <div class='space-y-[1em]'>
                <p>Иногда всё, что нужно — немного поддержки и знак, что вы не одна. В этом разделе собраны разные способы найти опору, понять свои чувства и чуть-чуть отпустить тяжесть.</p>
                <p>Карты, руны, гексаграммы, аудио послания - здесь все о чувствах, нежности и принятии. Они напоминают, что грусть — не враг, а часть пути к свету.
                </p>
            </div>

            <?= component('web/ui/button', [
                'variant' => 'primary',
                'slot' => 'Открыть доступ',
                'class' => 'hidden lg:flex',
            ]) ?>
        </div>

        <div class='flex flex-col gap-12 sm:flex-row items-start sm:gap-16 sm:justify-between'>
            <?= component('web/ui/button', [
                'variant' => 'primary',
                'slot' => 'Открыть доступ',
                'class' => 'lg:hidden',
            ]) ?>
            <?= component('shared/ui/image', [
                'sizes'    => 'mb|tb',
                'alt' => 'some white drawing',
                'path'     => '/assets/images/pages/sadness/hero-fg',
                'prt_class' => 'w-(--sq-size) h-[calc(var(--sq-size)*1.5)] self-center lg:shrink-0 rounded-xl shadow-accent -mt-(--offset) translate-y-(--offset)',
                'img_class' => 'size-full object-cover object-center',
            ]) ?>
        </div>
    </div>
    <?php end_slot(); ?>

</section>

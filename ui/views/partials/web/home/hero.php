<?php

use Enums\GameType;

$hive = \Base::instance();

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('components/web/layout/hero', [
    'class' => "bg-[url('/assets/images/pages/home/hero/hero-bg.webp')] bg-violet-100/75 bg-cover bg-center overflow-x-clip"
]); ?>
<section class='space-y-8 md:space-y-12'>
    <h1 class='mb-2'>Ответ ближе, чем кажется</h1>

    <div class='text-center text-balance sm:hidden md:block max-w-lg mx-auto isolate z-1'>
        <p><?= $hive->get('web.Любовь_Выбор_Страх_Надежда') ?></p>
        <p class='sm:hidden md:block'><?= $hive->get('web.Проходят_столетия_но_то_что_действительно_важно_человеку_остаётся_неизменным') ?></p>
    </div>

    <div class='lg:flex lg:gap-10'>

        <div class='text-balance hidden sm:block md:hidden max-w-2/3 mb-6'>
            <p><?= $hive->get('web.Любовь_Выбор_Страх_Надежда') ?></p>
            <p><?= $hive->get('web.Проходят_столетия_но_то_что_действительно_важно_человеку_остаётся_неизменным') ?></p>
        </div>

        <div class='relative isolate lg:basis-1/2'>
            <ul class='space-y-2 mb-20 2xl:mb-50'>
                <?php foreach (explode('|', $hive->get('web.Что_я_чувствую|Что_я_на_самом_деле_хочу|Куда_двигаться_дальше|Какое_решение_будет_правильным|Какими_могут_быть_наши_отношения|Когда_придет_время')) as $idx => $qtn) : ?>
                    <li style="--delay: <?= intdiv($idx * 1000, 4) ?>ms" class='bg-white bubble-animation px-[1em] py-[0.5em] rounded-full rounded-br-none shadow-accent w-fit lg:text-lg'>
                        <?= $qtn . '?' ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?= component('shared/ui/image', [
                'sizes'    => 'mb|tb',
                'alt' => 'Stairs',
                'path'     => '/assets/images/pages/home/hero/hero-fg',
                'prt_class' => 'aspect-square h-4/3 absolute! inset-y-0 sm:h-5/4 -top-10 sm:-top-5 -right-1/5 md:-right-5 bg-contain! -z-1 lg:right-auto lg:-left-[calc(20rem-10vw)] xl:-left-[calc(25rem-10vw)] 2xl:-left-[calc(20rem-15vw)] lg:h-160 lg:-top-1/4 lg:opacity-80 xl:h-180 2xl:h-200',
                'img_class' => 'size-full object-contain!',
            ]) ?>

        </div>


        <article cmp-game-container class='lg:basis-1/2 space-y-6'>
            <header class='text-center text-balance'>
                <h2 class='text-2xl md:text-3xl! lg:text-4xl!'>Давай познакомимся?</h2>
                <p class='mb-[0.5em]'> Почему ты здесь именно сегодня? Что привело тебя в пространство Lavanda.kim и с чего хочется начать?</p>
                <p> Авторский Оракул TheCat поможет прислушаться к себе, найти свою отправную точку и выбрать, куда заглянуть дальше.</p>
            </header>

            <div>
                <?php slot('components/web/layout/card-deck', [
                    'count' => count($cards),
                    'width' => 8,
                    'attrs' => ['cmp-game' => GameType::BONUS_HOME->value]
                ]); ?>

                <?php foreach ($cards as $card) : ?>
                    <?= component('web/ui/card', compact('card')) ?>
                <?php endforeach; ?>

                <?php end_slot(); ?>

                <article cmp-interpretation class='hidden'></article>
            </div>
            <div class='flex flex-col isolate items-center justify-center gap-4 md:flex-row lg:gap-6 text-center'>
                <div>
                    <?= component('web/ui/button', [
                        'variant' => 'primary',
                        'slot' => 'Открыть карту',
                        'class' => 'mx-auto mb-1',
                        'attrs' => [
                            'cmp-launch-game-btn' => true,
                            'cmp-visible-at-start' => true,
                            'cmp-visible-during' => true,
                        ]
                    ]) ?>
                    <?= component('web/ui/button', [
                        'variant' => 'primary',
                        'slot' => 'Попробовать снова',
                        'class' => 'mx-auto mb-1 hidden',
                        'attrs' => [
                            'cmp-reset-game-btn' => true,
                            'cmp-visible-at-end' => true,
                        ]
                    ]) ?>
                </div>
                <div>
                    <?= component('web/ui/button', [
                        'variant' => 'accent',
                        'slot' => 'Следующий раздел',
                        'class' => 'mx-auto mb-1',
                    ]) ?>
                </div>
            </div>
        </article>
    </div>
</section>
<?php end_slot(); ?>

<?php

use Enums\GameType;

$hive = \Base::instance();

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.карты_ленорман"),
]); ?>

<?php ob_start(); ?>
<?= $hive->get("web.старинное_гадание_госпожи_ленорман") ?>

<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p><?= $hive->get("web.карты_девушки_ленорман_известной_французской_предсказательницы_которая_в_свое_время_предвидела_смерть_наполеону_не_так_популярны_как_таро_они_периодически_появляются_в_специализированных_магазинах_все_чаще_и_чаще_но_до_сих_пор_остаются_неизвестными_в_большинстве_регионов_а_жаль_это_очень_интересные_карты_они_могут_многое_сказать_наблюдательному_человеку_вы_только_посмотрите_на_картинки_мы_выбрали_авторскую_колоду_в_стиле_ее_изображения_были_выполнены_художником_в_акварели_глядя_на_них_сразу_хочется_задать_вопрос_о_любви_но_они_далеко_не_только_об_этом") ?>
</p>
<?php $html = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/lenormand/hero-fg'; ?>

<?php $items = [
    [
        'img' => '/assets/images/pages/lenormand/man',
        'alt' => $hive->get("web.мужской_портрет_в_викторианском_стиле_профиль_молодого_мужчины_в_классическом_костюме_с_жилетом_и_галстуком_окружённого_ветвями_сирени"),
        'value' => 'man',
        'title' => $hive->get("web.предсказание_для_мужчины"),
    ],
    [
        'img' => '/assets/images/pages/lenormand/woman',
        'alt' => $hive->get("web.женский_портрет_в_викторианском_стиле_профиль_молодой_женщины_с_собранными_волосами_украшенными_сиренью_в_светлом_платье_с_кружевным_воротником_и_букетом_сирени"),
        'value' => 'woman',
        'title' => $hive->get("web.предсказание_для_женщины"),
    ]
]; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image')); ?>

    <ul
        class="grid [--sq-size:min(100%,20.6rem)] md:[--sq-size:25.6rem] -mt-12 sm:-mt-25 px-2 relative grid-cols-[repeat(auto-fit,var(--sq-size))] justify-center gap-8 md:gap-10">

        <?php foreach ($items as $idx => $item) : ?>
            <li
                cmp-selected-lenormand
                data-value="<?= $item['value'] ?>"
                class="rounded-3xl group relative overflow-clip shadow-accent px-6 py-8 md:px-8 md:py-10 aspect-square flex flex-col">

                <?= component('shared/ui/image', [
                    'path' => $item['img'],
                    'alt' => $item['alt'],
                    'sizes' => 'mb',
                    'prt_class' => 'size-full absolute! inset-0',
                ]) ?>

                <span class='flex absolute group-hover:opacity-100 group-focus-within:opacity-100 group-focus-visible:opacity-100 transition-opacity items-end inset-0 bg-linear-to-t from-primary to-transparent opacity-0 group-aria-selected:opacity-100'>
                    <h2 class='text-xl text-white text-center md:text-2xl -translate-y-1/2 font-bold isolate uppercase'><?= $item['title'] ?></h2>
                </span>

                <button
                    class='absolute cursor-pointer inset-0'
                    type='button'
                    cmp-reveal-game-btn>
                </button>
            </li>

        <?php endforeach; ?>

    </ul>

</section>


<?php ob_start(); ?>
<div>
    <div cmp-visible-at-start class='text-balance max-w-[min(100%,50rem)] mx-auto space-y-[1em]'>
        <p><?= $hive->get("web.формат_этого_набора_отличается_от_привычных_карточных_инструментов_вы_почувствуете_это_в_процессе_описания_достаточно_ясные_но_мы_рекомендуем_не_ограничиваться_только_текстом_обратите_внимание_и_на_изображения_иногда_именно_детали_образы_и_общее_настроение_карты_подсказывают_больше_чем_слова_у_каждого_откликается_чтото_своё") ?>
        </p>

        <p><?= $hive->get("web.в_центре_набора_находится_ключ_образ_который_вы_выбрали_на_предыдущем_шаге_он_символизирует_вас_и_ваше_положение_в_ситуации_в_зависимости_от_выбора_это_может_быть_образ_дамы_или_джентльмена") ?>
        </p>

        <p><?= $hive->get("web.если_рядом_появляется_другой_образ_противоположный_по_роли_он_может_указывать_на_значимого_человека_в_вашей_жизни_партнёра_близкого_или_того_чьё_присутствие_сейчас_особенно_важно_когда_такая_карта_расположена_близко_к_ключу_это_часто_отражает_ощущение_близости_человека_рядом_с_вами_в_вашей_реальности_или_в_поле_внимания") ?>
        </p>
    </div>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.получить_ответ"),
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-at-start' => true
        ],
        'class' => 'mx-auto'
    ]) ?>

    <ul cmp-lenormand-game
        cmp-game="<?= GameType::LENORMAND->value ?>"
        class='grid gap-1 justify-center grid-cols-[repeat(auto-fill,minmax(7rem,1fr))] transition-[grid-template-columns] duration-500 ease-in-out'>
        <?php foreach ($cards as $card) : ?>
            <?= component('web/ui/flip-card', [
                'card' => $card
            ]) ?>
        <?php endforeach; ?>
    </ul>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.попробовать_снова"),
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>
    <?= component('web/ui/button', [
        'variant' => 'accent',
        'slot' => $hive->get("web.следующий_раздел"),
        'href' => next_game_route(),
        'class' => 'mx-auto -mt-2 lg:-mt-5 mb-1 w-fit hidden',
        'attrs' => [
            'cmp-visible-at-end' => true
        ],
    ]) ?>

    <?= component('web/ui/arrow-hint') ?>
</div>
<?php $slot1 = ob_get_clean(); ?>

<?= component('web/layout/game-stage', [
    'slots' => [$slot1],
    'class' => 'hidden'
]); ?>

<?php end_slot(); ?>

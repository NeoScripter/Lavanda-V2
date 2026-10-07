<?php

use Enums\GameType;

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Карты Ленорман',
]); ?>

<?php ob_start(); ?>
Старинное гадание госпожи Ленорман
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>Карты девушки Ленорман - известной французской предсказательницы, которая в свое время предвидела смерть Наполеону, - не так популярны, как Таро. Они периодически появляются в специализированных магазинах, все чаще и чаще, но до сих пор остаются неизвестными в большинстве регионов. А жаль! Это очень интересные карты, они могут многое сказать наблюдательному человеку. Вы только посмотрите на картинки! Мы выбрали авторскую колоду в стиле Lavanda. Ее изображения были выполнены художником в акварели. Глядя на них сразу хочется задать вопрос о любви. Но они далеко не только об этом.</p>
<?php $html = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/lenormand/hero-fg'; ?>

<?php $items = [
    [
        'img' => '/assets/images/pages/lenormand/man',
        'alt' => 'Мужской портрет в викторианском стиле: профиль молодого мужчины в классическом костюме с жилетом и галстуком, окружённого ветвями сирени.',
        'value' => 'man',
        'title' => 'Предсказание для мужчины',
    ],
    [
        'img' => '/assets/images/pages/lenormand/woman',
        'alt' => 'Женский портрет в викторианском стиле: профиль молодой женщины с собранными волосами, украшенными сиренью, в светлом платье с кружевным воротником и букетом сирени.',
        'value' => 'woman',
        'title' => 'Предсказание для женщины',
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
        <p>Формат этого набора отличается от привычных карточных инструментов — вы почувствуете это в процессе. Описания достаточно ясные, но мы рекомендуем не ограничиваться только текстом. Обратите внимание и на изображения: иногда именно детали, образы и общее настроение карты подсказывают больше, чем слова. У каждого откликается что-то своё.</p>

        <p>В центре набора находится Ключ — образ, который вы выбрали на предыдущем шаге. Он символизирует вас и ваше положение в ситуации. В зависимости от выбора это может быть образ Дамы или Джентльмена.</p>

        <p>Если рядом появляется другой образ, противоположный по роли, он может указывать на значимого человека в вашей жизни: партнёра, близкого или того, чьё присутствие сейчас особенно важно. Когда такая карта расположена близко к Ключу, это часто отражает ощущение близости — человека рядом с вами, в вашей реальности или в поле внимания.</p>
    </div>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Получить ответ',
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
        'slot' => 'Попробовать снова',
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>

    <?= component('web/ui/arrow-hint') ?>
</div>
<?php $slot1 = ob_get_clean(); ?>

<?= component('web/layout/game-stage', [
    'slots' => [$slot1],
    'class' => 'hidden'
]); ?>

<?php end_slot(); ?>

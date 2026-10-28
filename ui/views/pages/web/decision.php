<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.мне_грустно"),
    'class' => "bg-background"
]); ?>

<!-- Hero Section -->
<?= partial('web/decision/hero') ?>

<section>
    <div class='mx-auto max-w-xl lg:flex lg:*:flex-1 lg:max-w-full lg:gap-23'>
        <div class='mb-[1.5em] lg:mb-0'>
            <h2 class='text-left lg:text-left text-2xl md:text-4xl lg:text-5xl font-bold normal-case'><?= $hive->get("web.правильного_решения_в_реальности_не_существует_есть_только_сделанный_выбор_и_его_последствия") ?>
            </h2>
            <small class='text-xl md:text-2xl lg:text-3xl text-primary font-semibold'><?= $hive->get("web.эльчин_сафарли") ?>
            </small>
        </div>
        <div class='space-y-[0.75em] text-balance lg:translate-y-23 lg:-mb-23'>
            <p><?= $hive->get("web.в_этом_разделе_собраны_символические_системы_разных_культур_каждая_из_них_предлагает_свой_взгляд_на_происходящее_через_архетипы_древние_тексты_образы_звуки_или_случайность") ?>
            </p>
        </div>
    </div>
</section>
<?php

$items = [
    [
        'title' => $hive->get("web.практика"),
        'exerpt' => $hive->get("web.современные_техники_принятия_решений_и_анализа_ситуации_помогают_навести_порядок_в_мыслях_увидеть_новые_варианты_и_сделать_следующий_шаг_более_осознанно_здесь_собраны_простые_упражнения_которые_легко_применять_в_жизни_и_работе_попробуйте_одну_из_практик_порой_решение_становится_очевиднее_уже_после_нескольких_минут_спокойного_анализа"),
        'url' => $hive->alias('practice')
    ],
    [
        'title' => $hive->get("web.руны"),
        'exerpt' => $hive->get("web.задолго_до_появления_современных_психологических_методик_жители_северной_европы_вырезали_руны_на_камне_дереве_и_металле_для_них_это_был_алфавит_память_народа_и_язык_символов_сегодня_руны_продолжают_жить_уже_в_другом_качестве_как_способ_поддержки_поиск_предсказаний_как_амулет_или_знак_со_смыслом_задай_вопрос_и_узнай_какую_руну_сегодняшний_день_приготовил_тебе"),
        'url' => $hive->alias('runes')
    ],
    [
        'title' => $hive->get("web.расклад_карт"),
        'exerpt' => $hive->get("web.на_протяжении_веков_люди_замечали_что_символы_начинают_звучать_иначе_когда_появляются_рядом_друг_с_другом_так_рождается_история_со_своими_вопросами_поворотами_и_неожиданными_деталями_именно_в_этих_сочетаниях_многие_находят_мысли_которых_прежде_не_замечали_выбери_колоду_по_душе_и_посмотри_какая_история_сложится"),
        'url' => '/cards'
    ],
    [
        'title' => $hive->get('web.книга_перемен_ицзин'),
        'exerpt' => $hive->get("web.книга_перемен_сопровождает_китайскую_философию_почти_три_тысячи_лет_её_не_читают_как_обычную_книгу_с_ней_советуются_каждая_гексаграмма_предлагает_не_готовый_ответ_а_другой_взгляд_на_происходящее_позволяя_увидеть_ситуацию_шире_бросай_три_древние_монеты_и_расшифруй_свою_гексаграмму_прямо_сейчас"),
        'url' => '/cards'
    ],
    [
        'title' => $hive->get("web.игры_разума"),
        'exerpt' => $hive->get("web.этот_простой_но_невероятно_действенный_полезный_инструмент_в_виде_колоды_мак_я_получила_от_члена_профессиональной_психотерапевтической_лиги_с_разрешения_автора_эти_карты_используются_и_у_нас"),
        'url' => $hive->alias('mind_games')
    ]
]; ?>

<section>
    <ul class='grid sm:grid-cols-[repeat(auto-fill,28rem)] xl:grid-cols-[repeat(auto-fill,35.4rem)] gap-y-15 sm:gap-17 2xl:gap-23 justify-center lg:even:-mb-23'>
        <?php foreach ($items as $idx => $item) : ?>
            <li class='bg-white rounded-xl px-8 lg:px-12 space-y-[1em] transition-[outline] ease-in-out duration-200 hover:ring-4 hover:ring-primary relative sm:px-10 py-11 w-full shadow-accent lg:even:translate-y-23'>
                <?= component('shared/ui/image', [
                    'sizes' => 'mb',
                    'path' => '/assets/images/pages/decision/item-' . $idx + 1,
                    'prt_class' => 'mx-auto w-full max-w-2/3 aspect-square bg-contain!',
                    'img_class' => $idx !== 4 ? 'object-contain' : '',
                ]) ?>

                <h3 class='uppercase md:text-3xl lg:text-3xl'><?= $item['title'] ?></h3>
                <p><?= $item['exerpt'] ?></p>
                <a href="<?= $item['url'] ?>" class='absolute inset-0'></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php end_slot(); ?>

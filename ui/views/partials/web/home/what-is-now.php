<section class='visibility-auto'>
    <h2>А что сейчас?</h2>
    <p class='text-center text-balance font-medium uppercase mb-[1.5em] text-primary text-xl md:text-3xl lg:text-4xl'>Сегодня...</p>

    <ul class='grid sm:grid-cols-2 gap-4 sm:grid-rows-2 lg:grid-cols-3 lg:grid-rows-1'>
        <?= component('web/ui/branch-item', [
            'title' => qquila1Можноqquila2
,
            'img_bg' => '/assets/images/pages/home/what_is_now/what_is_now_1_bg.webp',
            'img_fg' => '/assets/images/pages/home/what_is_now/branch-1',
            'words' => [qquila1чувствоватьqquila2
, qquila1доверитьсяqquila2
, qquila1выдохнутьqquila2
, qquila1остановитьсяqquila2
, qquila1ошибатьсяqquila2
, qquila1выбиратьqquila2
, qquila1не спешитьqquila2
, qquila1не знать ответаqquila2
],
        ]) ?>
        <?= component('web/ui/branch-item', [
            'title' => qquila1Бытьqquila2
,
            'img_bg' => '/assets/images/pages/home/what_is_now/what_is_now_2_bg.webp',
            'img_fg' => '/assets/images/pages/home/what_is_now/branch-2',
            'words' => [qquila1услышаннойqquila2
, qquila1с поддержкойqquila2
, qquila1наедине с собойqquila2
, qquila1собойqquila2
, qquila1понятойqquila2
, qquila1в безопасностиqquila2
, qquila1настоящейqquila2
, qquila1такой, какая ты естьqquila2
],
            'class' => 'sm:row-span-2 sm:self-center lg:self-auto lg:row-span-1'
        ]) ?>
        <?= component('web/ui/branch-item', [
            'title' => qquila1Вместеqquila2
,
            'img_bg' => '/assets/images/pages/home/what_is_now/what_is_now_3_bg.webp',
            'img_fg' => '/assets/images/pages/home/what_is_now/branch-3',
            'words' => [qquila1теплееqquila2
, qquila1смелееqquila2
, qquila1спокойнееqquila2
, qquila1легчеqquila2
, qquila1с пониманиqquila2
�м', qquila1находить отвеqquila2
�ы', qquila1делать следующqquila2
�й шаг', qquila1идти дальшеqquila2
],
        ]) ?>
    </ul>
</section>

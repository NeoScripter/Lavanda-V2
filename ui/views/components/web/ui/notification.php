    <div cmp-notification class="fixed z-100 bg-white shadow-accent pb-4 px-4 top-28 rounded-xl inset-x-0 mx-auto max-w-140 w-9/10 transition-transform duration-500 ease-in">
        <?= component('shared/ui/image', [
            'sizes'    => 'mb',
            'alt' => 'Black Cat',
            'path'     => '/assets/images/shared/notifications/cat/cat',
            'prt_class' => 'aspect-square max-w-35 w-full mx-auto -mt-20 mb-2',
            'img_class' => 'size-full object-contain!',
        ]) ?>

        <div cmp-notification-content class='*:text-base! text-center text-balance'>
            <p>Покупка прошла успешно!</p>
            <p>Доступ к платным разделам сайта открыт.</p>
            <p>Хорошего вам дня и настроения!</p>
        </div>
    </div>

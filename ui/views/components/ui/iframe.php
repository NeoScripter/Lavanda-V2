<div
    component-iframe-wrapper
    data-video-src="<?= $video_path ?>"
    class="aspect-square relative sm:aspect-video w-full bg-black">
    <div
        component-iframe
        class="size-full relative flex items-center justify-center group">
        <figure class="absolute inset-0 size-full overflow-clip">
            <img src="<?= $img_path ?>" alt="<?= $img_alt ?>"
                class="size-full transition-transform duration-500 ease-in-out group-hover:scale-105 object-contain object-center">
        </figure>
        <span class="bg-black/75 absolute inset-0 size-full block isolate"></span>
        <span class="text-white size-20 isolate">
            <?= svg('circle-play') ?>
        </span>
        <button
            component-iframe-trigger
            class="absolute inset-0 size-full isolate"></button>
    </div>
</div>

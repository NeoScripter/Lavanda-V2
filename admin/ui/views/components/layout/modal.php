<template
    component-modal-template
    data-modal-id="<?= $modal_id ?>">
    <div
        component-modal
        class='size-screen fixed inset-0 z-20 flex-wrap opacity-0 hidden overflow-y-auto bg-black/40 backdrop-blur-sm transition-opacity duration-300 ease-in-out'>
        <div
            component-modal-slot
            class='bg-user-background m-auto rounded-sm w-max px-7 py-10 animate-expand'>

            <?= $slot ?? '' ?>
        </div>
    </div>
</template>

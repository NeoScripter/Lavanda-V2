<?php

extract(component_props(
    required: ['slots'],
    optional: ['class' => '', 'labels' => ['Выбор лаванды']],
    props: get_defined_vars(),
)); ?>

<section cmp-playground-wrapper
    class="<?= cc('full-bleed lg:px-(--px-lg)', $class) ?>">
    <div cmp-playground>
        <nav class="flex flex-col xs:flex-row justify-center xs:gap-[1.25em] <?= count($labels) < 2 ? 'hidden' : '' ?>">
            <?php foreach ($labels as $idx => $label) : ?>
                <label cmp-playground-toggle class='has-checked:bg-primary has-checked:text-white xs:min-w-[15em] font-medium bg-white cursor-pointer py-[0.75em] uppercase text-center xs:rounded-t-2xl px-[1.25em] text-primary transition-colors'>
                    <input name="section" type="radio" class="hidden" value="<?= 'playground-toggle-' . $idx + 1 ?>" <?= $idx === 0 ? 'checked' : '' ?> />
                    <?= $label ?>
                </label>
            <?php endforeach; ?>
        </nav>

        <div class='py-14.5 px-7 sm:px-9 sm:py-25 text-white lg:px-12 lg:py-12 2xl:px-21.5 2xl:py-23 bg-linear-(--bg-primary) lg:rounded-xl'>
            <?php foreach ($slots as $idx => $slot) : ?>
                <div id="<?= 'playground-slot-' . $idx + 1 ?>" cmp-playground-slot>
                    <?= $slot ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

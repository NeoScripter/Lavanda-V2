<?php

extract(component_props(
    required: ['slots'],
    optional: ['class' => '', 'labels' => ['Выбор лаванды']],
    props: get_defined_vars(),
)); ?>

<section cmp-game-stage
    class="<?= cc('full-bleed lg:px-(--px-lg) group', $class) ?>">
    <div>
        <nav class="flex flex-col xs:flex-row justify-center xs:gap-[1.25em] <?= count($labels) < 2 ? 'hidden' : '' ?>">
            <?php foreach ($labels as $idx => $label) : ?>
                <label
                    class='has-checked:bg-primary has-checked:text-white xs:min-w-[15em] font-medium bg-white cursor-pointer py-[0.75em] uppercase text-center xs:rounded-t-2xl px-[1.25em] text-primary transition-colors'>
                    <input cmp-game-toggle
                        name="section" type="radio" class="hidden" value="<?= 'slot-' . $idx + 1 ?>" <?= $idx === 1 ? 'checked' : '' ?> />
                    <?= $label ?>
                </label>
            <?php endforeach; ?>
        </nav>

        <div class='py-14.5 px-7 sm:px-9 sm:py-25 text-white lg:px-12 lg:py-12 2xl:px-21.5 2xl:py-23 bg-linear-(--bg-primary) lg:rounded-t-xl lg:group-has-[article[cmp-interpretation].hidden]:rounded-b-xl'>
            <?php foreach ($slots as $idx => $slot) : ?>
                <div cmp-game-container
                    id="<?= 'slot-' . $idx + 1 ?>">
                    <?= $slot ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <article cmp-interpretation
        class='bg-white py-14.5 rounded-b-xl px-7 sm:px-9 sm:py-25 lg:px-12 lg:py-12 2xl:px-21.5 2xl:py-23 hidden'>
    </article>
</section>

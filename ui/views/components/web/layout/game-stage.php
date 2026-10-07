<?php

extract(component_props(
    required: ['slots'],
    optional: ['class' => '', 'labels' => ['Выбор лаванды']],
    props: get_defined_vars(),
)); ?>

<section cmp-game-stage
    class="<?= cc('full-bleed lg:px-(--px-lg) group', $class) ?>">
    <div>
        <nav class="flex flex-col xs:flex-row has-[input:last-of-type:checked]:border-b border-white xs:border-none justify-center xs:gap-[1.25em] <?= count($labels) < 2 ? 'hidden' : '' ?>">
            <?php foreach ($labels as $idx => $label) : ?>
                <label
                    tabindex="0"
                    class='has-checked:bg-primary has-checked:opacity-100 opacity-60 hover:opacity-100 focus-visible:opacity-100 has-checked:cursor-default has-checked:pointer-events-none has-checked:text-white xs:min-w-[15em] font-medium bg-white cursor-pointer py-[0.75em] uppercase text-center xs:rounded-t-2xl px-[1.25em] text-primary transition-[opacity,background-color,color] duration-300 ease'>
                    <input cmp-game-toggle
                        name="section" type="radio" class="hidden" value="<?= 'slot-' . $idx + 1 ?>" <?= $idx === 0 ? 'checked' : '' ?> />
                    <?= $label ?>
                </label>
            <?php endforeach; ?>
        </nav>

        <div class='py-14.5 px-7 sm:px-9 md:py-20 text-white lg:px-12 lg:py-18 2xl:px-21.5 2xl:py-23 bg-linear-(--bg-primary) lg:rounded-t-xl lg:group-has-[article[cmp-interpretation].hidden]:rounded-b-xl'>
            <?php foreach ($slots as $idx => $slot) : ?>
                <div cmp-game-container
                    class='[&>*>*:has(+*.hidden):has(+*+*.hidden):has(+*+*+*:not(.hidden))]:mb-(--space-y) [&>*>*:has(+*.hidden):has(+*+*:not(.hidden))]:mb-(--space-y) [&>*>*:has(+*:not(.hidden))]:mb-(--space-y) [--space-y:2rem] md:[--space-y:2.5rem] lg:[--space-y:3rem]'
                    id="<?= 'slot-' . $idx + 1 ?>">
                    <?= $slot ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <article cmp-interpretation
        class='bg-white py-14.5 rounded-b-xl px-7 sm:px-9 sm:py-25 lg:px-12 lg:py-12 2xl:px-21.5 2xl:py-23 hidden'>
    </article>

    <template cmp-theme-picker>
        <div>
            <h4 class='text-foreground font-semibold text-xl md:text-2xl xl:text-3xl'>Выберите тему для интерпретации</h4>
            <nav class='flex flex-col sm:flex-wrap sm:flex-row mt-10 justify-center gap-y-[1em] gap-x-[1.25em]'>
                <button cmp-theme-btn class='font-medium bg-primary-muted/75 text-white cursor-pointer py-[0.75em] uppercase text-center sm:min-w-80 rounded-2xl px-[1.25em] transition-[opacity,background-color,color] duration-300 ease [[selected-theme]]:bg-primary'>
                </button>
            </nav>
        </div>
    </template>
</section>

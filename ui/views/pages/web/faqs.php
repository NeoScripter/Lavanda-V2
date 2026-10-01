<?php

extract(component_props(
    required: ['faqs'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'FAQs',
]); ?>

<section class='pt-(--pt-lg)'>
    <h1 class='mb-[1.75em]!'>Часто задаваемые вопросы</h1>

    <div class='space-y-3 md:space-y-4'>
        <?php foreach ($faqs as $faq) : ?>
            <details name="faqs" class='bg-white px-[1.5em] py-[1em] rounded-2xl group relative'>
                <summary class='flex justify-between gap-4 before:absolute before:inset-0 before:cursor-pointer'>
                    <span>
                        <?= $faq->question ?>
                    </span>
                    <span component-icon class='hidden md:flex size-[1.5em] group-open:rotate-45 transition-transform'>
                        <?= svg('plus') ?>
                    </span>
                </summary>
                <p class='pt-[1em]'>
                    <?= \Markdown::instance()->convert($faq->answer) ?>
                </p>
            </details>
        <?php endforeach; ?>
    </div>

</section>

<?php end_slot(); ?>

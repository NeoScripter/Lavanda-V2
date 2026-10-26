<?php

extract(component_props(
    required: ['code', 'name'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?= component('email/heading', ['label' => "Hello, $name"]) ?>
<p><?= \Base::instance()->get('email.вот_ваш_код_верификации') ?>:</p>
<p style="font-weight: bold;font-size: 40px;text-transform: uppercase;margin-block:0.5em;"><?= $code ?></p>

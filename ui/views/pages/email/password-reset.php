<?php

extract(component_props(
    required: ['href'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?= component('email/heading', ['label' => "Здравствуйте"]) ?>
<p>Для смены пароля перейдите пожалуйста по данной ссылке:</p>
<?= component('email/link', ['label' => "Ссылка", 'href' => $href]) ?>
<p>Ссылка перестанет быть достуной через 3 минуты.</p>
<p>Если у вас переход по ссылке не работает, скопируйте и вставьте ее отсюда:</p>
<p style="font-size:12px;text-wrap:balance;"><?= $href ?></p>

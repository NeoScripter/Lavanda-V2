<?php

extract(component_props(
    required: ['name', 'email', 'message'],
    optional: ['emphasis', 'other'],
    props: get_defined_vars(),
));

$hive = \Base::instance();
?>

<?= component('email/heading', ['label' => "Здравствуйте, Татьяна"]) ?>
<p>Новый запрос на консультацию от пользователя Lavanda:</p>

<p>1. Как к тебе обращаться?</p>
<p><?= $name ?></p>
<p>2. Куда тебе ответить?</p>
<p><?= $email ?></p>
<p>3. С чем ты хочешь разобраться?</p>
<p><?= $message ?></p>
<?php if (! empty('emphasis')) : ?>
    <p>4. На что хотелось бы посмотреть в первую очередь?</p>
    <?= $emphasis ?>
<?php endif; ?>
<?php if (! empty('other')) : ?>
    <p>5. Есть ли что-то ещё, что мне важно знать?</p>
    <?= $other ?>
<?php endif; ?>

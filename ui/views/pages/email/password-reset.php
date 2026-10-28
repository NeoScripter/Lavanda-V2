<?php

extract(component_props(
    required: ['href'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();
?>

<?= component('email/heading', [
    'label' => $hive->get("web.здравствуйте")
]) ?>
<p><?= $hive->get("web.для_смены_пароля_перейдите_пожалуйста_по_данной_ссылке_") ?>
</p>
<?= component('email/link', [
    'label' => $hive->get("web.ссылка"),
    'href' => $href
]) ?>
<p><?= $hive->get("web.ссылка_перестанет_быть_достуной_через_минуты_") ?>
</p>
<p><?= $hive->get("web.если_у_вас_переход_по_ссылке_не_работает_скопируйте_и_вставьте_ее_отсюда_") ?>
</p>
<p style="font-size:12px;text-wrap:balance;"><?= $href ?></p>

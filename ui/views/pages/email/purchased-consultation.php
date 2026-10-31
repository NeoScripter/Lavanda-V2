<?php

extract(component_props(
    required: ['name'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();
?>

<?= component('email/heading', ['label' => $hive->get('web.здравствуйте') . ", $name"]) ?>
<p><?= $hive->get("web.благодарим_вам_за_приобретение_персональной_консультации_от_пожалуйста,_перейдите_по_указанной_ссылке_и_заполните_вебформу") ?>
</p>
<?= component('email/link', [
    'label' => $hive->get("web.ссылка"),
    'href' => remove_extra_slashes(getenv('APP_URL') . '/' . $hive->alias('consultation')),
]) ?>

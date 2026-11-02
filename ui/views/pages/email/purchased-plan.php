<?php

extract(component_props(
    required: ['name', 'html'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();
?>

<?= component('email/heading', ['label' => $hive->get('web.здравствуйте') . ", $name"]) ?>
<p><?= $hive->get("web.благодарим_вам_за_покупку") ?></p>
<p><?= $html ?></p>

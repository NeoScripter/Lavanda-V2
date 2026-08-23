<?php

use Enums\Locale;
use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: [],
    optional: ['class' => ''],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<form method="POST" action="<?= $hive->alias('resource_locale') ?>" class="<?= 'grid gap-2' . $class ?>">
    <?= csrf() ?>
    <input type="hidden" name="_method" value="PUT" />
    <label for="locale-select"><?= $hive->get('admin.select_language') ?></label>
    <div>
        <select onchange="this.form.submit()" name="<?= SessionKey::RESOURCE_LOCALE->value ?>" class="cursor-pointer w-full" id="locale-select">
            <?php foreach (Locale::labels() as $value => $label) : ?>
                <option <?= $value === $locale ? 'selected' : '' ?> value="<?= $value ?>"><?= $label ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</form>

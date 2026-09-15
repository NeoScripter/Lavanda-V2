<?php

use Enums\CardVariant;
use Enums\Locale;
use Enums\SessionKey;

$hive = Base::instance();

$hive->set('redis_port', (int) getenv('REDIS_PORT'));
$hive->set('redis_host', getenv('REDIS_HOST'));

$hive->set('CACHE', "redis={$hive->get('redis_host')}:{$hive->get('redis_port')}");

$session = new Session(function () {
    return true;
});

if (! $hive->exists('SESSION.csrf')) {
    $hive->set('SESSION.csrf', $session->csrf());
}

if (! $hive->exists('SESSION.' . SessionKey::RESOURCE_LOCALE->value)) {
    $hive->set('SESSION.' . SessionKey::RESOURCE_LOCALE->value, Locale::ENGLISH->value);
}

if (! $hive->exists('SESSION.' . SessionKey::CARD_VARIANT->value)) {
    $hive->set('SESSION.' . SessionKey::CARD_VARIANT->value, CardVariant::TAROT->value);
}

if ($hive->exists('COOKIE.locale')) {
    $hive->set('LANGUAGE', $hive->COOKIE['locale']);
} else {
    $hive->set('LANGUAGE', 'ru');
}

$hive->copy('SESSION.csrf', 'CSRF');

$flash = \Flash::instance();
$hive->set('FLASH', $flash);

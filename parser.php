<?php

if (empty($_SERVER['DOCUMENT_ROOT']))
    $_SERVER['DOCUMENT_ROOT'] = getcwd();

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Tumen\Xmlparser\RssLink;

if (isset($_POST["link"])) {
    $rss_link = $_POST["link"];
} else {
    die();
}

$rss = new RssLink(
    $rss_link
);

$url = 'https://zakupki.gov.ru';

$data_words = [
    'Наименование организации',
    'Место нахождения',
    'Наименование закупки',
    'Контактное лицо',
    'Контактный телефон',
    'Адрес электронной почты',
    'Организация, осуществляющая размещение',
    'Наименование объекта закупки',
    'Ответственное должностное лицо',
    'Номер контактного телефона'
];

$word_class = [
    'section.blockInfo__section' => 'span.section__info',
    'div.col-9' => 'div.common-text__value'
];

$rule_class = [
    'div.cardMainInfo__title',
    'div.registry-entry__header-top__title'
];

$arData = $rss->getBodyLink()->getLinks($url)->Parse($data_words, $word_class, $rule_class);

$arData->createCsv();

echo "<a href='data.csv' target='_blank'>скачать</a>";
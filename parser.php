<?php

if (empty($_SERVER['DOCUMENT_ROOT']))
    $_SERVER['DOCUMENT_ROOT'] = getcwd();

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GuzzleHttp\Exception\GuzzleException;
use Tumen\Xmlparser\RssLink;

$rss_link='https://zakupki.gov.ru/epz/order/extendedsearch/rss.html?morphology=on&search-filter=Дате+размещения&pageNumber=1&sortDirection=false&recordsPerPage=_50&showLotsInfoHidden=false&sortBy=UPDATE_DATE&fz44=on&fz223=on&ppRf615=on&af=on&ca=on&pc=on&pa=on&priceFromGeneral=900000000&priceToGeneral=1000000000&currencyIdGeneral=-1&OrderPlacementSmallBusinessSubject=on&OrderPlacementRnpData=on&OrderPlacementExecutionRequirement=on&orderPlacement94_0=0&orderPlacement94_1=0&orderPlacement94_2=0';

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

try {
    $arData = $rss->getBodyLink()->getLinks($url)->Parse($data_words, $word_class, $rule_class)->createCsv();
} catch (GuzzleException|Exception $e) {
    echo $e->getMessage(). '\n';
    echo $e->getLine(). '\n';
    echo $e->getFile(). '\n';
}

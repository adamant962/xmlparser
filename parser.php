<?php

use Tumen\Xmlparser\SendLink;

if (empty($_SERVER['DOCUMENT_ROOT']))
    $_SERVER['DOCUMENT_ROOT'] = getcwd();

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

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
$attribute = 'href';
$filterParent = 'div.registry-entry__header-mid__number';
$filterChild = 'a';
$domain = 'https://zakupki.gov.ru';
$rule_name = 'Закон';

$countElementsOnPage = 10;
$countPage = 2;
date_default_timezone_set('Europe/Moscow');
$csvFileName = 'данные от ' . date("F j, Y, g:i:s a") . '.csv';

$link = new SendLink(
    $data_words,
    $word_class,
    $rule_class,
    $attribute,
    $filterParent,
    $filterChild,
    $domain,
    $rule_name,
    $countPage,
    $countElementsOnPage,
    $csvFileName
);

$link->SendLinkPagination();
<?php

use Tumen\Xmlparser\SendLink;

if (empty($_SERVER['DOCUMENT_ROOT'])) {
    $_SERVER['DOCUMENT_ROOT'] = getcwd();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Тестовые данные
 */
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
    'Номер контактного телефона',
    /*структурированный*/
    'Телефон',
    'Наименование Заказчика',
    'Место нахождения (адрес)',
    'ФИО лица, утвердившего план-график закупок'
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

$countElementsOnPage = 20;
$countPage = 2;

$linkXml = "https://zakupki.gov.ru/epz/order/extendedsearch/rss.html?searchString=&morphology=on&search-filter=Дате+обновления&pageNumber=20&sortDirection=false&recordsPerPage=_50&showLotsInfoHidden=false&savedSearchSettingsIdHidden=&sortBy=UPDATE_DATE&fz44=on&fz223=on&af=on&placingWayList=&selectedLaws=&priceFromGeneral=&priceFromGWS=&priceFromUnitGWS=&priceToGeneral=&priceToGWS=&priceToUnitGWS=&currencyIdGeneral=-1&publishDateFrom=&publishDateTo=&applSubmissionCloseDateFrom=&applSubmissionCloseDateTo=&customerIdOrg=&customerFz94id=&customerTitle=&okpd2Ids=&okpd2IdsCodes=";
$xmlLinkTag = 'link';

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
    $countElementsOnPage
);

$link->SendLinkPagination();
#$link->SendLinkXml($xmlLinkTag, $linkXml);
<?php

if (empty($_SERVER['DOCUMENT_ROOT']))
    $_SERVER['DOCUMENT_ROOT'] = getcwd();

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GuzzleHttp\Exception\GuzzleException;
use Tumen\Xmlparser\RssLink;


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

$i = 1;

$count = 2;

while ($i <= $count):
    $rss_link = 'https://zakupki.gov.ru/epz/order/extendedsearch/results.html?searchString=&morphology=on&search-filter=Дате+обновления&pageNumber=' . $i . '&sortDirection=false&recordsPerPage=_50&showLotsInfoHidden=false&savedSearchSettingsIdHidden=&sortBy=UPDATE_DATE&fz44=on&fz223=on&af=on&placingWayList=&selectedLaws=&priceFromGeneral=400000&priceFromGWS=&priceFromUnitGWS=&priceToGeneral=450000&priceToGWS=&priceToUnitGWS=&currencyIdGeneral=-1&publishDateFrom=&publishDateTo=&applSubmissionCloseDateFrom=&applSubmissionCloseDateTo=&customerIdOrg=&customerFz94id=&customerTitle=&okpd2Ids=&okpd2IdsCodes=&OrderPlacementSmallBusinessSubject=on&OrderPlacementRnpData=on&OrderPlacementExecutionRequirement=on&orderPlacement94_0=0&orderPlacement94_1=0&orderPlacement94_2=0';
    $rss = new RssLink(
        $rss_link
    );

    $links = $rss->getBodyLink()->getPaginationLinks($url)->Parse($data_words, $word_class, $rule_class)->createCsv();
    $i++;
endwhile;




/*try {
    $arData = $rss->getBodyLink()->getLinks($url)->Parse($data_words, $word_class, $rule_class)->createCsv();
} catch (GuzzleException|Exception $e) {
    echo $e->getMessage(). '\n';
    echo $e->getLine(). '\n';
    echo $e->getFile(). '\n';
}*/

<?php

if (empty($_SERVER['DOCUMENT_ROOT']))
    $_SERVER['DOCUMENT_ROOT'] = getcwd();

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GuzzleHttp\Exception\GuzzleException;
use Tumen\Xmlparser\RssLink;

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

$i = 1;
$perPage = 10;

$count = 2;
# 17:03 запуск 18:13 конец
while ($i <= $count):
    $rss_link = 'https://zakupki.gov.ru/epz/order/extendedsearch/results.html?searchString=&morphology=on&search-filter=Дате+обновления&pageNumber=' . $i . '&sortDirection=false&recordsPerPage=_' . $perPage . '&showLotsInfoHidden=false&savedSearchSettingsIdHidden=&sortBy=UPDATE_DATE&fz44=on&af=on&ca=on&pc=on&placingWayList=ZK504%2CZKP504%2CZK20%2CZKP20%2CEZK504%2CEZK20%2CEA44%2CEAP44%2CEA20%2CEAP20%2CEAB44%2CEAO44%2CEAO20%2CEAB20%2CEEA44%2CEEA20%2CINM111%2CINMP111%2COKD111%2CZKK111%2CZKKU111%2CPO111%2COK111%2CZA111%2CZK111%2CZKKD111%2CEP111%2CZKB111%2CZP111%2COKU111%2COK504%2COKP504%2COK20%2COKP20%2COKK504%2COKA504%2COKA20%2COKI20%2COKB20%2CEOK504%2CEOK20%2COKB504%2COKI504%2CZP504%2CZPP504%2CEZP504%2CPO44%2CPOP44%2COKU504%2COKUP504%2COKUI504%2CEOKU504%2COKUK504%2CZK44%2CZKP44%2CZKI44%2CZKOP44%2CZKE44%2CZKOO44%2COK44%2COKP44%2CPK44%2COKA44%2CEOK44%2CZKK44%2CZKKP44%2CZKKE44%2CZKKI44%2COKD504%2COKDP504%2CEOKD504%2COKDI504%2COKDK504%2CZKKU44%2CZKKUP44%2CZKKUE44%2CZKKUI44%2CZKKD44%2CZKKDP44%2CZKKDI44%2CZKKDE44%2COKD44%2COKDP44%2CEOKD44%2CZP44%2CZPP44&selectedLaws=FZ44&etp_7360767=on&etp=7360767&bankSupportTag_0=on&bankSupportTag=0&priceFromGeneral=2000000&priceFromGWS=&priceFromUnitGWS=&priceToGeneral=&priceToGWS=&priceToUnitGWS=&currencyIdGeneral=1&publishDateFrom=01.06.2022&publishDateTo=15.08.2022&applSubmissionCloseDateFrom=&applSubmissionCloseDateTo=&customerIdOrg=&customerFz94id=&customerTitle=&customerPlace=5277335&customerPlaceCodes=77000000000&S=on&M=on&NOT_FSM=on&okpd2Ids=&okpd2IdsCodes=&OrderPlacementSmallBusinessSubject=on&OrderPlacementRnpData=on&OrderPlacementExecutionRequirement=on&orderPlacement94_0=0&orderPlacement94_1=0&orderPlacement94_2=0';
    $rss = new RssLink(
        $rss_link
    );

    echo $i . "";

    #$links = $rss->getBodyLink()->filterLinkAttribute($filterParent, $filterChild, $domain, $attribute)->getLinks()->Parse($data_words, $word_class, $rule_class)->createCsv();
    $links = $rss
        ->getBodyLink()
        ->filterLinkAttribute($filterParent, $filterChild, $domain, $attribute)
        ->getLinks()
        ->Parse($data_words, $word_class, $rule_class)
        ->createCsv();

    $i++;
endwhile;




/*try {
    $arData = $rss->getBodyLink()->getLinks($url)->Parse($data_words, $word_class, $rule_class)->createCsv();
} catch (GuzzleException|Exception $e) {
    echo $e->getMessage(). '\n';
    echo $e->getLine(). '\n';
    echo $e->getFile(). '\n';
}*/

<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class SendLink implements SendLinkInterface
{
    private array $data_words;
    private array $word_class;
    private array $rule_class;
    private string $attribute;
    private string $filterParent;
    private string $filterChild;
    private string $domain;
    private string $rule_name;
    private int $countPage;
    private int $countElementsOnPage;
    private string $csvFileName;

    public function __construct
    (
        array  $data_words,
        array  $word_class,
        array  $rule_class,
        string $attribute,
        string $filterParent,
        string $filterChild,
        string $domain,
        string $rule_name,
        int    $countPage,
        int    $countElementsOnPage
    )

    {
        $this->data_words = $data_words;
        $this->word_class = $word_class;
        $this->rule_class = $rule_class;
        $this->attribute = $attribute;
        $this->filterParent = $filterParent;
        $this->filterChild = $filterChild;
        $this->domain = $domain;
        $this->rule_name = $rule_name;
        $this->countPage = $countPage;
        $this->countElementsOnPage = $countElementsOnPage;
    }

    public function SendLinkPagination(): bool
    {
        /**
         * отправка ссылки с пагинацие
         */
        $i = 1;
        while ($i <= $this->countPage):
            /**
             * указываем в ссылки GET параметры пагинации
             *
             * @var int $this- >countElementsOnPage количество элементов на странице
             * @var int $this- >countPage количество страниц
             */
            $rss_link = 'https://zakupki.gov.ru/epz/order/extendedsearch/results.html?morphology=on&search-filter=Дате+размещения&pageNumber=' . $i . '&sortDirection=false&recordsPerPage=_' . $this->countElementsOnPage . '&showLotsInfoHidden=false&sortBy=UPDATE_DATE&fz44=on&af=on&ca=on&placingWayList=ZK504%2CZKP504%2CZK20%2CZKP20%2CEZK504%2CEZK20%2CEA44%2CEAP44%2CEA20%2CEAP20%2CEAB44%2CEAO44%2CEAO20%2CEAB20%2CEEA44%2CEEA20%2CINM111%2CINMP111%2COKD111%2CZKK111%2CZKKU111%2CPO111%2COK111%2CZA111%2CZK111%2CZKKD111%2CEP111%2CZKB111%2CZP111%2COKU111%2COK504%2COKP504%2COK20%2COKP20%2COKK504%2COKA504%2COKA20%2COKI20%2COKB20%2CEOK504%2CEOK20%2COKB504%2COKI504%2CZP504%2CZPP504%2CEZP504%2CPO44%2CPOP44%2COKU504%2COKUP504%2COKUI504%2CEOKU504%2COKUK504%2CZK44%2CZKP44%2CZKI44%2CZKOP44%2CZKE44%2CZKOO44%2COK44%2COKP44%2CPK44%2COKA44%2CEOK44%2CZKK44%2CZKKP44%2CZKKE44%2CZKKI44%2COKD504%2COKDP504%2CEOKD504%2COKDI504%2COKDK504%2CZKKU44%2CZKKUP44%2CZKKUE44%2CZKKUI44%2CZKKD44%2CZKKDP44%2CZKKDI44%2CZKKDE44%2COKD44%2COKDP44%2CEOKD44%2CZP44%2CZPP44&selectedLaws=FZ44&etp_7360767=on&etp=7360767&bankSupportTag_0=on&bankSupportTag=0&priceFromGeneral=2000000&currencyIdGeneral=1&publishDateFrom=01.06.2022&publishDateTo=15.08.2022&customerPlace=5277335&customerPlaceCodes=77000000000&S=on&M=on&NOT_FSM=on&OrderPlacementSmallBusinessSubject=on&OrderPlacementRnpData=on&OrderPlacementExecutionRequirement=on&orderPlacement94_0=0&orderPlacement94_1=0&orderPlacement94_2=0';

            $rss = new RssLink(
                $rss_link
            );

            try {
                $rss->getBodyLink()
                    ->filterLinkAttribute($this->filterParent, $this->filterChild, $this->domain, $this->attribute)
                    ->linksToParse()
                    ->Parse($this->data_words, $this->word_class, $this->rule_class, $this->rule_name)
                    ->createCsv();
            } catch (GuzzleException|Exception $e) {
                echo $e->getMessage() . "\n";
                echo $e->getLine() . "\n";
                echo $e->getFile() . "\n";
            }
            $i++;

        endwhile;

        return true;
    }

    /**
     * @param string $link - тег по которому будут фильтроваться данные
     * @param string $xmlLinkDoc - ссылка xml документ
     * @return bool
     */
    public function SendLinkXml(string $link, string $xmlLinkDoc): bool
    {
        $rss = new RssLink(
            $xmlLinkDoc
        );

        try {
            $rss->getBodyLink()
                ->filterLinkText($link, $this->domain)
                ->linksToParse()
                ->Parse($this->data_words, $this->word_class, $this->rule_class, $this->rule_name)
                ->createCsv();
        } catch (GuzzleException|Exception $e) {
            echo $e->getMessage() . "\n";
            echo $e->getLine() . "\n";
            echo $e->getFile() . "\n";
        }

        return true;
    }
}
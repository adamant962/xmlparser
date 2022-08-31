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

    public function __construct
    (
        array $data_words,
        array $word_class,
        array $rule_class,
        string $attribute,
        string $filterParent,
        string $filterChild,
        string $domain,
        string $rule_name,
        int $countPage,
        int $countElementsOnPage
    ) {
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
         * Отправка ссылки с пагинацией
         */
        $i = 1;
        while ($i <= $this->countPage):
            /**
             * Указываем в ссылки GET параметры пагинации
             *
             * @var int $this- >countElementsOnPage количество элементов на странице
             * @var int $this- >countPage количество страниц
             *
             * для Mac OS в Encode указать второй параметр MacCyrillic
             */
            $rss_link = 'https://zakupki.gov.ru/epz/orderplan/search/results.html?morphology=on&search-filter=Дате+размещения&structuredCheckBox=on&structured=true&notStructured=false&fz44=on&actualPeriodRangeYearFrom=2022&actualPeriodRangeYearTo=2023&customerPlace=5277335%2C5277327&customerPlaceCodes=77000000000%2C50000000000&sortBy=BY_MODIFY_DATE&pageNumber=' . $i . '&sortDirection=false&recordsPerPage=_' . $this->countElementsOnPage . '&showLotsInfoHidden=false&searchType=false';

            $rss = new RssLink(
                $rss_link
            );

            try {
                $rss->getBodyLink()
                    ->filterLinkAttribute($this->filterParent, $this->filterChild, $this->domain, $this->attribute)
                    ->linksToParse()
                    ->Parse($this->data_words, $this->word_class, $this->rule_class, $this->rule_name)
                    ->formatData()
                    ->Encode("UTF-8", "cp1251")
                    ->createCsv();
            } catch (GuzzleException|Exception $e) {
                echo $e->getMessage() . "\n";
                echo $e->getLine() . "\n";
                echo $e->getFile() . "\n";
                echo 'error page' . $i . "\n";
            }
            echo "page " . $i . "\n";
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
                ->formatData()
                ->Encode()
                ->createCsv();
        } catch (GuzzleException|Exception $e) {
            echo $e->getMessage() . "\n";
            echo $e->getLine() . "\n";
            echo $e->getFile() . "\n";
        }

        return true;
    }
}
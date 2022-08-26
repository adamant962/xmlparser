<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;
use Symfony\Component\DomCrawler\Crawler;

class FilterLinks implements FilterLinksInterface
{
    private string $bodyLink;

    public function __construct(string $bodyLink)
    {
        $this->bodyLink = $bodyLink;
    }

    /**
     * @throws Exception
     */

    /**
     * получение массива ссылок для последующей фильтрации
     */
    public function filterLinkAttribute (string $linkClass, string $linkClass2, string $domain, string $attributes): LinksInterface
    {
        /**
         * фильтрация по родителя и его ребенку
         */
        $crawler = new Crawler($this->bodyLink);
        $link = $crawler->filter($linkClass)->filter($linkClass2);

        /**
         * получение ссылок на детальную чтраницу по атриббуту
         */
        $arFilteredLinks = [];
        foreach ($link as $domElement) {
            /** @var object $domElement */
            $arFilteredLinks[] = $domain . $domElement->getAttribute($attributes);
        }

        /**
         * полученные данные отправляем в объект для последующего парсинга
         */
        return new Links($arFilteredLinks);
    }

    public function filterLinkText(string $linkClass, string $domain): LinksInterface
    {
        $crawler = new Crawler($this->bodyLink);
        $link = $crawler->filter($linkClass);

        /**
         * получение ссылок на детальную страницу по соддержания селектора
         */
        $arLink = [];
        foreach ($link as $domElement) {
            $arLink[] = $domain . $domElement->textContent;
        }
        return new Links($arLink);
    }
}
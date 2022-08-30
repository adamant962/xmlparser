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
     * Получение массива ссылок для последующей фильтрации
     */
    public function filterLinkAttribute(
        string $linkClass,
        string $linkClass2,
        string $domain,
        string $attributes
    ): LinksInterface {
        /**
         * Фильтрация по родителя и его ребенку
         */
        $crawler = new Crawler($this->bodyLink);
        $link = $crawler->filter($linkClass)->filter($linkClass2);

        /**
         * Получение ссылок на детальную страницу по атрибуту
         */
        $arFilteredLinks = [];
        foreach ($link as $domElement) {
            /** @var object $domElement */
            $arFilteredLinks[] = $domain . $domElement->getAttribute($attributes);
        }

        /**
         * Полученные данные отправляем в объект для последующего парсинга
         */
        return new Links($arFilteredLinks);
    }

    public function filterLinkText(string $linkClass, string $domain): LinksInterface
    {
        $crawler = new Crawler($this->bodyLink);
        $link = $crawler->filter($linkClass);

        /**
         * Получение ссылок на детальную страницу по содержания селектора
         */
        $arLink = [];
        foreach ($link as $domElement) {
            $arLink[] = $domain . $domElement->textContent;
        }
        return new Links($arLink);
    }
}
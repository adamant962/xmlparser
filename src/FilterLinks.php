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
     * @throws Exception
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
        if (is_array($arFilteredLinks))
            return new Links($arFilteredLinks);

        throw new Exception('Не удалось отфильтровать и получить ссылки по атрибуту');
    }

    /**
     * @throws Exception
     */
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

        if(is_array($arLink))
            return new Links($arLink);

        throw new Exception('Не удалось отфильтровать и получить ссылки по тексту');
    }
}
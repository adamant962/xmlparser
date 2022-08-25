<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;
use Symfony\Component\DomCrawler\Crawler;

class Links implements LinksInterface
{
    private string $xml;

    public function __construct(string $xml)
    {
        $this->xml = $xml;
    }

    /**
     * @throws Exception
     */
    public function getLinks(string $url): ParserXmlInterface
    {
        $crawler = new Crawler($this->xml);
        $link = $crawler->filter('link');

        $arLink = [];
        foreach ($link as $domElement) {
            $arLink[] = $url . $domElement->textContent;
        }

        if (is_array($arLink))
            return new ParserXml($arLink);

        throw new Exception('Не удалось создать массив с ссылками');
    }
}
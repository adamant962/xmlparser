<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;
use Symfony\Component\DomCrawler\Crawler;

class FilterLinks implements FilterLinksInterface
{
    private string $xml;

    public function __construct(string $xml)
    {
        $this->xml = $xml;
    }

    /**
     * @throws Exception
     */

    public function filterLinkAttribute (string $linkClass, string $linkClass2, string $domain, string $attributes): LinksInterface
    {
        $crawler = new Crawler($this->xml);
        $link = $crawler->filter($linkClass)->filter($linkClass2);

        $arFilteredLinks = [];
        foreach ($link as $domElement) {
            /** @var object $domElement */
            $arFilteredLinks[] = $domain . $domElement->getAttribute($attributes);
        }

        return new Links($arFilteredLinks);
    }

    public function filterLinkText(string $linkClass, string $domain): LinksInterface
    {
        $crawler = new Crawler($this->xml);
        $link = $crawler->filter($linkClass);

        $arLink = [];
        foreach ($link as $domElement) {
            $arLink[] = $domain . $domElement->textContent;
        }
        return new Links($arLink);
    }
}
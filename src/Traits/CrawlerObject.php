<?php

declare(strict_types=1);

namespace Tumen\Xmlparser\Traits;

use Symfony\Component\DomCrawler\Crawler;

trait CrawlerObject
{
    public function Crawler($detail_page): Crawler
    {
        return new Crawler($detail_page);
    }
}

<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface FilterLinksInterface
{
    /* массив детальных страниц */
    public function filterLinkAttribute(string $linkClass, string $linkClass2, string $domain, string $attributes): LinksInterface;

    public function filterLinkText(string $linkClass, string $domain): LinksInterface;
}
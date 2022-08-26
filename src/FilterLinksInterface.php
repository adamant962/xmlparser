<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface FilterLinksInterface
{
    /**
     * получение ссылки по атрибуту
     */
    public function filterLinkAttribute(string $linkClass, string $linkClass2, string $domain, string $attributes): LinksInterface;

    /**
     * получение ссылки по тексту
     */
    public function filterLinkText(string $linkClass, string $domain): LinksInterface;
}
<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface FilterLinksInterface
{
    /**
     * Получение ссылки по атрибуту
     */
    public function filterLinkAttribute(
        string $linkClass,
        string $linkClass2,
        string $domain,
        string $attributes
    ): LinksInterface;

    /**
     * Получение ссылки по тексту
     */
    public function filterLinkText(string $linkClass, string $domain): LinksInterface;
}
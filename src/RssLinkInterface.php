<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface RssLinkInterface
{
    /**
     * Создаем объект с данными для последующей фильтрации
     */
    public function getBodyLink(): FilterLinksInterface;
}
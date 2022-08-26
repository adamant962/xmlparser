<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface RssLinkInterface
{
    /**
     * создаем обьект с данными для полседующей фильтрации
     */
    public function getBodyLink(): FilterLinksInterface;
}
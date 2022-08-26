<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface RssLinkInterface
{
    /* ссылка на документ */
    public function getBodyLink(): FilterLinksInterface;
}
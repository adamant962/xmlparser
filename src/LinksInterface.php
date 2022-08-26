<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface LinksInterface
{
    /* массив детальных страниц */
    public function getLinks(): ParserXmlInterface;
}
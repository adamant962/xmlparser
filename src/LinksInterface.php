<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface LinksInterface
{
    /**
     * отправка в парсер
     */
    public function linksToParse(): ParserXmlInterface;
}
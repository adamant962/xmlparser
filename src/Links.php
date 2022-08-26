<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;

class Links implements LinksInterface
{
    private array $arFilteredLinks;

    public function __construct(array $arFilteredLinks)
    {
        $this->arFilteredLinks = $arFilteredLinks;
    }

    /**
     * @throws Exception
     */
    public function getLinks(): ParserXmlInterface
    {
        if (!empty($this->arFilteredLinks))
            return new ParserXml($this->arFilteredLinks);

        throw new Exception('Не удалось создать массив с ссылками');
    }
}
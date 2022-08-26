<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface ParserXmlInterface
{
    /**
     * парсинг данных с указанными параметрами
     */
    public function Parse(array $data_words, array $word_class, array $rule_class, string $rule_name): CsvCreateInterface;
}
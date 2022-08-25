<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface ParserXmlInterface
{
    public function Parse(array $data_words, array $word_class, array $rule_class): object;
}
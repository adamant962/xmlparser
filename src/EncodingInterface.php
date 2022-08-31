<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface EncodingInterface
{
    public function Encode(string $fromEncoding, string $toEncoding): CsvCreateInterface;
}
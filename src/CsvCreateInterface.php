<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface CsvCreateInterface
{
    public function createCsv($file = null, $col_delimiter = ';', $row_delimiter = "\r\n");
}
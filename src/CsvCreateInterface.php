<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface CsvCreateInterface
{
    /**
     * запись в файл
     */
    public function createCsv($file, $col_delimiter = ';', $row_delimiter = "\r\n");
}
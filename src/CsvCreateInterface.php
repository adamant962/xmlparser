<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface CsvCreateInterface
{
    /**
     * Запись в файл
     */
    public function createCsv($file);
}
<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface FormattingDataInterface
{
    /*
     * форматирование данных (удаление пробелов, переносов строк, приведение к нужному формату для записи в csv фалй)
     * */
    public function formatData($col_delimiter = ';', $row_delimiter = "\r\n"): CsvCreateInterface;
}
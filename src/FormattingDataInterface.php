<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface FormattingDataInterface
{
    /*
     * Форматирование данных (удаление пробелов, переносов строк, приведение к нужному формату для записи в csv файл)
     * */
    public function formatData($col_delimiter = ';', $row_delimiter = "\r\n"): EncodingInterface;
}
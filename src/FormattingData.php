<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;

class FormattingData implements FormattingDataInterface
{
    private array $rsData;

    public function __construct(array $rsData)
    {
        $this->rsData = $rsData;
    }

    /**
     * @throws Exception
     */
    public function formatData($col_delimiter = ';', $row_delimiter = "\r\n"): EncodingInterface
    {
        /**
         * Переменная для записи
         */
        $csvStr = '';

        /**
         * Перебор данных для записи
         */
        foreach ($this->rsData as $data) {
            $row = [];

            /**
             * Перебор строк для форматирования
             */
            foreach ($data as $col_val) {
                /**
                 * Если есть переносы в строчке, пробелы, двоеточие, то удаляем
                 */
                if (preg_match('/\r\n|\r|\n/', $col_val) || strpos($col_val, ';')) {
                    $col_val = preg_replace('/\r\n|\r|\n/', ' ', $col_val);
                    $col_val = str_replace(';', ' ', $col_val);
                }
                /**
                 * Удаляем пробелы
                 */
                $row[] = trim($col_val);
            }

            /**
             * Записываем в переменную, вставляя разделитель и переносы строк
             */
            $csvStr .= implode($col_delimiter, $row) . $row_delimiter;
        }
        /**
         * Удаляем пробел из конца строки
         */
        $csvStr = rtrim($csvStr, $row_delimiter);

        if (!empty($csvStr))
            return new Encoding($csvStr);

        throw new Exception('Не удалось отформатировать данные для записи');
    }
}
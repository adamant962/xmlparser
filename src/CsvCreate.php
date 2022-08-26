<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

class CsvCreate implements CsvCreateInterface
{
    private array $rsData;

    public function __construct(array $rsData)
    {
        $this->rsData = $rsData;
    }

    /**
     * @var string $file название файла для записи, по уммолчанию "data.csv"
     * @var string $col_delimiter разделитель для разделения данных
     * @var string $row_delimiter перенос строк
    */
    public function createCsv($file = 'data.csv', $col_delimiter = ';', $row_delimiter = "\r\n")
    {
        /**
         * переменная для записи
         */
        $CSV_str = '';

        /**
         * перебор данных для записи
         */
        foreach ($this->rsData as $data) {
            $row = [];

            /**
             * перебор строк для форматирования
            */
            foreach ($data as $col_val) {
                /**
                 * если есть переносы в строчке, пробелы, двоеточие, то удаляем
                 */
                if (preg_match('/\r\n|\r|\n/', $col_val) || strpos($col_val, ';')) {
                    $col_val = preg_replace('/\r\n|\r|\n/', ' ', $col_val);
                    $col_val = str_replace(';', ' ', $col_val);
                }
                /**
                 * удаляем пробелы
                 */
                $row[] = trim($col_val);
            }

            /**
             * записываем в переменную, вставляя разделитель и переносы строк
             */
            $CSV_str .= implode($col_delimiter, $row) . $row_delimiter;
        }
        /**
         * удаляем пробел из конца строки
         */
        $CSV_str = rtrim($CSV_str, $row_delimiter);

        if ($file) {
            /**
             * задаем кодировку
             */
            $CSV_str = iconv("UTF-8", "cp1251", $CSV_str);

            /**
             * записываем в файл, с параметрами дозаписывания и переноса строки нового елемента
            */
            $done = file_put_contents($file, PHP_EOL . $CSV_str, FILE_APPEND);

            return $done ? $CSV_str : false;
        }

        return $CSV_str;
    }
}
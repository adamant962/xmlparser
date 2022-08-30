<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

class CsvCreate implements CsvCreateInterface
{
    private string $CSV_str;

    public function __construct(string $CSV_str)
    {
        $this->CSV_str = $CSV_str;
    }

    /**
     * @var string $file Название файла для записи, по умолчанию "data.csv"
     * @var string $col_delimiter Разделитель для разделения данных
     * @var string $row_delimiter Перенос строк
     */
    public function createCsv($file = 'data.csv')
    {
        if ($file) {
            /**
             * Задаем кодировку
             */
            $this->CSV_str = iconv("UTF-8", "cp1251", $this->CSV_str);

            /**
             * Записываем в файл, с параметрами дописывания и переноса строки нового элемента
             */
            $done = file_put_contents($file, PHP_EOL . $this->CSV_str, FILE_APPEND);

            return $done ? $this->CSV_str : false;
        }

        return $this->CSV_str;
    }
}
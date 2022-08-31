<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;

class CsvCreate implements CsvCreateInterface
{
    private string $csvStrFinal;

    public function __construct(string $csvStrFinal)
    {
        $this->csvStrFinal = $csvStrFinal;
    }

    /**
     * @throws Exception
     * @var string $col_delimiter Разделитель для разделения данных
     * @var string $row_delimiter Перенос строк
     * @var string $file Название файла для записи, по умолчанию "data1.csv"
     */
    public function createCsv($file = 'data.csv')
    {
        if ($file) {
            /**
             * Записываем в файл, с параметрами дописывания и переноса строки нового элемента
             */
            $done = file_put_contents($file, PHP_EOL . $this->csvStrFinal, FILE_APPEND);

            return $done ? $this->csvStrFinal : false;
        }

        throw new Exception('Не удалось записать файл');
    }
}
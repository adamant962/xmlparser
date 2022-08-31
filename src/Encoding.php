<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;

class Encoding implements EncodingInterface
{
    private string $CsvCharsetString;

    public function __construct(string $CsvCharsetString)
    {
        $this->CsvCharsetString = $CsvCharsetString;
    }

    /**
     * @throws Exception
     */
    public function Encode(string $fromEncoding = "UTF-8", string $toEncoding = "cp1251"): CsvCreateInterface
    {

        /**
         * Задаем кодировку
         */
        if ($this->CsvCharsetString)
            $this->CsvCharsetString = iconv($fromEncoding, $toEncoding, $this->CsvCharsetString);

         if (!empty($this->CsvCharsetString))
            return new CsvCreate($this->CsvCharsetString);

        throw new Exception('Не удалось преобразовать кодировку строк');
    }
}
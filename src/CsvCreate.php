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

    public function createCsv($file = 'data.csv', $col_delimiter = ';', $row_delimiter = "\r\n")
    {
        $CSV_str = '';

        foreach ($this->rsData as $data) {
            $row = [];
            foreach ($data as $col_val) {
                if (preg_match('/\r\n|\r|\n/', $col_val) || strpos($col_val, ';')) {
                    $col_val = preg_replace('/\r\n|\r|\n/', ' ', $col_val);
                    $col_val = str_replace(';', ' ', $col_val);
                }
                $row[] = trim($col_val);
            }
            $CSV_str .= implode($col_delimiter, $row) . $row_delimiter;
        }
        $CSV_str = rtrim($CSV_str, $row_delimiter);

        if ($file) {
            $CSV_str = iconv("UTF-8", "cp1251", $CSV_str);

            $done = file_put_contents($file, PHP_EOL . $CSV_str, FILE_APPEND);

            return $done ? $CSV_str : false;
        }

        return $CSV_str;
    }
}
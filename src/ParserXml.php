<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

class ParserXml implements ParserXmlInterface
{
    private array $arLinks;

    public function __construct(array $arLinks)
    {
        $this->arLinks = $arLinks;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function Parse(array $data_words, array $word_class, array $rule_class): CsvCreateInterface
    {
        $rsData = [];
        $client = new Client();

        foreach ($this->arLinks as $key => $one_link) {
            $detail = $client->request('GET', $one_link);
            $detail_page = (string)$detail->getBody();

            $detail_body = new Crawler($detail_page);

            foreach ($word_class as $parent => $child) {
                foreach ($data_words as $word) {
                    $detail_info = $detail_body->filter($parent)->reduce(
                        function (Crawler $node) use ($word) {
                            return str_starts_with($node->text(), $word);
                        }
                    )->filter($child);
                    foreach ($detail_info as $domElement) {
                        $rsData[$key][$word] = $domElement->textContent;
                    }
                }
            }

            foreach ($rule_class as $class) {
                $rule_info = $detail_body->filter($class);

                foreach ($rule_info as $domElement) {
                    $rsData[$key]["Закон"] = $domElement->textContent;
                }
            }

            $rsData[$key]["link"] = $one_link;
        }

        if (is_array($rsData) && !empty($rsData))
            return new CsvCreate($rsData);

        throw new Exception('Не удалось получить данные');
    }
}
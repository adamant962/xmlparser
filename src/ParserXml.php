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
     *
     * парсинг
     */
    public function Parse(array $data_words, array $word_class, array $rule_class, string $rule_name): CsvCreateInterface
    {
        $rsData = [];
        $client = new Client();

        /**
         * перебор массива ссылок
         */
        foreach ($this->arLinks as $key => $one_link) {
            /**
             * получаем тело каждой страницы
             *
             * используем Crawler для фильтрации данных по словам
             */
            $detail = $client->request('GET', $one_link);
            $detail_page = (string)$detail->getBody();

            $detail_body = new Crawler($detail_page);

            /**
             * перебираем массив классов(который мы задали) для фильтрации по ним родитель -> ребенок
             */
            foreach ($word_class as $parent => $child) {
                /**
                 * перебираем массив слов(который мы задали) для фильтрации по ним
                 * слово рядом с нужными нам данными, опираемся на классы
                 */
                foreach ($data_words as $word) {
                    /**
                     * фильтр: родитель слово рялом с нужным нам значением,
                     * ребенок слово которое начинается на указанный нами параметр
                     */
                    $detail_info = $detail_body->filter($parent)->reduce(
                        function (Crawler $node) use ($word) {
                            return str_starts_with($node->text(), $word);
                        }
                    )->filter($child);

                    /**
                     * получаем массив с данными в виде, параметр: значение
                    */
                    foreach ($detail_info as $domElement) {
                        $rsData[$key][$word] = $domElement->textContent;
                    }
                }
            }

            /**
             * для данных которых нет в нужном нам селекторе, пишется фильтр отдельно
             * и дописывается в массив с данными
             */
            foreach ($rule_class as $class) {
                $rule_info = $detail_body->filter($class);

                /**
                 * Запись
                 */
                foreach ($rule_info as $domElement) {
                    $rsData[$key][$rule_name] = $domElement->textContent;
                }
            }

            /**
             * записываем в результирующий массив данные с ссылкой на детальную страницу
             */
            $rsData[$key]["link"] = $one_link;
        }

        /**
         * отправляем данные на запись в csv файл
         */
        if (is_array($rsData) && !empty($rsData))
            return new CsvCreate($rsData);

        throw new Exception('Не удалось получить данные');
    }
}
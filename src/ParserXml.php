<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class ParserXml implements ParserXmlInterface
{
    private array $arLinks;
    private Client $client;


    public function __construct(array $arLinks)
    {
        $this->arLinks = $arLinks;
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     *
     * парсинг
     */
    public function Parse(
        array $data_words,
        array $word_class,
        array $rule_class,
        string $rule_name
    ): FormattingDataInterface {
        $rsData = [];

        /**
         * Перебор массива ссылок
         */
        foreach ($this->arLinks as $key => $one_link) {
            /**
             * Получаем тело каждой страницы
             *
             * используем Crawler для фильтрации данных по словам
             */
            $detail = $this->client->request('GET', $one_link);
            $detail_page = (string)$detail->getBody();

            $detail_body = new Crawler($detail_page);

            /**
             * Перебираем массив классов(который мы задали) для фильтрации по ним родитель -> ребенок
             */
            foreach ($word_class as $parent => $child) {
                /**
                 * Перебираем массив слов(который мы задали) для фильтрации по ним
                 * слово рядом с нужными нам данными, опираемся на классы
                 */
                foreach ($data_words as $word) {
                    /**
                     * Фильтр: родитель слово рядом с нужным нам значением,
                     * ребенок слово которое начинается на указанный нами параметр
                     */
                    $detail_info = $detail_body->filter($parent)->reduce(
                        function (Crawler $node) use ($word) {
                            return str_starts_with($node->text(), $word);
                        }
                    )->filter($child);

                    /**
                     * Получаем массив с данными в виде, параметр: значение
                     */
                    foreach ($detail_info as $domElement) {
                        $rsData[$key][$word] = $domElement->textContent;
                    }
                }
            }

            /**
             * Для данных которых нет в нужном нам селекторе, пишется фильтр отдельно
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
             * Записываем в результирующий массив данные со ссылкой на детальную страницу
             */
            $rsData[$key]["link"] = $one_link;
        }

        /**
         * Отправляем данные на запись в csv файл
         */
        if (is_array($rsData) && !empty($rsData)) {
            return new FormattingData($rsData);
        }

        throw new Exception('Не удалось получить и отфильтровать данные');
    }
}
<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RssLink implements RssLinkInterface
{
    private string $rss_link;

    public function __construct($rss_link)
    {
        $this->rss_link = $rss_link;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getBodyLink(): FilterLinksInterface
    {
        /**
         * Получаем ссылку
         */
        $client = new Client();
        $response = $client->request(
            'GET',
            $this->rss_link
        );

        /**
         * Получаем тело ссылки
         */
        $xmlString = (string)$response->getBody();

        /**
         * Создаем объект с данными для последующей фильтрации
         */
        $xmlBody = new FilterLinks($xmlString);

        /**
         * Возврат объекта
         */
        if (!empty($xmlBody)) {
            return $xmlBody;
        }

        throw new Exception('Не удалось получить тело ссылки');
    }
}
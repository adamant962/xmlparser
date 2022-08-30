<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RssLink implements RssLinkInterface
{
    private string $rss_link;
    private Client $client;

    public function __construct(string $rss_link)
    {
        $this->rss_link = $rss_link;
        $this->client = new Client();
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
        $response = $this->client->request(
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
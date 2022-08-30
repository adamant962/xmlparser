<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Tumen\Xmlparser\Traits\ClientObject;

class RssLink implements RssLinkInterface
{
    use ClientObject;

    private string $rss_link;
    private object $client;

    public function __construct($rss_link)
    {
        $this->rss_link = $rss_link;
        $this->client = $this->newClient();
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
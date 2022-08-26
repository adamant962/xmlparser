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
         * получаем ссылку
         */
        $client = new Client();
        $response = $client->request(
            'GET',
            $this->rss_link
        );

        /**
         * получаем тело ссылки
         */
        $xmlString = (string)$response->getBody();

        /**
         * создаем обьект с данными для полседующей фильтрации
         */
        $xmlBody = new FilterLinks($xmlString);

        /**
         * возврат объекта
         */
        if (!empty($xmlBody))
            return $xmlBody;

        throw new Exception('Не удалось получить тело ссылки');
    }
}
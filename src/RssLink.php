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
    public function getBodyLink(): LinksInterface
    {
        /* получаем тело ссылки */
        $client = new Client();
        $response = $client->request(
            'GET',
            $this->rss_link
        );

        $doc = (string)$response->getBody();

        /* создаем объект с телом ссылки */
        if ($doc)
            return new Links($doc);

        throw new Exception('Не удалось получить тело ссылки');
    }
}
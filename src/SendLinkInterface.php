<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface SendLinkInterface
{
    /*
     * отправка ссылки с пагинацией
     * */
    public function SendLinkPagination(): bool;

    /*
     * отправка на парсинг xml документа
     * */
    public function SendLinkXml(string $link, string $xmlLinkDoc): bool;
}
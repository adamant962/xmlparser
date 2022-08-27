<?php

declare(strict_types=1);

namespace Tumen\Xmlparser;

interface SendLinkInterface
{
    public function SendLinkPagination(): bool;

    public function SendLinkXml(string $link, string $xmlLinkDoc): bool;
}
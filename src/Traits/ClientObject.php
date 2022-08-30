<?php

declare(strict_types=1);

namespace Tumen\Xmlparser\Traits;

use GuzzleHttp\Client;

trait ClientObject
{
    public function newClient(): Client
    {
        return new Client();
    }
}
<?php

declare(strict_types=1);

namespace App\Tests\Tool;

use GuzzleHttp\Handler\MockHandler;

trait HttpClientTrait
{
    private ?MockHandler $mockHandler = null;

    public function getHttpClientMockHandler(): MockHandler
    {
        if ($this->mockHandler === null) {
            $this->mockHandler = static::getContainer()->get('app.infrastructure.http_client.guzzle.mock_handler');
        }

        return $this->mockHandler;
    }
}

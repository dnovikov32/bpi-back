<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher\HttpClient;

use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    /**
     * @throws GuzzleException
     */
    public function sendRequest(ApiRequestInterface $request): ResponseInterface;
}

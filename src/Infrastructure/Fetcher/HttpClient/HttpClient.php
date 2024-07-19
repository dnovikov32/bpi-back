<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher\HttpClient;

use App\Infrastructure\Fetcher\Request\RequestBuilderInterface;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements HttpClientInterface
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly RequestBuilderInterface $requestBuilder
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function sendRequest(ApiRequestInterface $request): ResponseInterface
    {
        return $this->client->request(
            $this->requestBuilder->getMethod(),
            $this->requestBuilder->getUrl($request),
            $this->requestBuilder->buildRequest($request)
        );
    }
}

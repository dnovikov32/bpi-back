<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher\Request;

use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;

abstract class BaseRequestBuilder implements RequestBuilderInterface
{
    public function __construct(
        private readonly string $method,
        private readonly string $url,
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrl(ApiRequestInterface $request): string
    {
        return $this->url;
    }

    /**
     * @return array{
     *     query: array<string, string>,
     *     json: array<string, string>,
     *     headers: array<string, string>
     * }
     */
    public function buildRequest(ApiRequestInterface $request): array
    {
        return [
            'query' => $this->buildQuery($request),
            'json' => $this->buildJson($request),
            'headers' => $this->buildHeaders($request)
        ];
    }

    /**
     * @return array<string, string>
     */
    public function buildQuery(ApiRequestInterface $request): array
    {
        return [];
    }

    /**
     * @return array<string, string>
     */
    public function buildJson(ApiRequestInterface $request): array
    {
        return [];
    }

    /**
     * @return array<string, string>
     */
    public function buildHeaders(ApiRequestInterface $request): array
    {
        return [];
    }
}

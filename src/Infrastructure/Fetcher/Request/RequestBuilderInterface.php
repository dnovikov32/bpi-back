<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher\Request;

use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;

interface RequestBuilderInterface
{
    public function getUrl(ApiRequestInterface $request): string;

    public function getMethod(): string;

    /**
     * @return array{
     *     query: array<string, string>,
     *     json: array<string, string>,
     *     headers: array<string, string>
     * }
     */
    public function buildRequest(ApiRequestInterface $request): array;

    /**
     * @return array<string, string>
     */
    public function buildQuery(ApiRequestInterface $request): array;

    /**
     * @return array<string, string>
     */
    public function buildJson(ApiRequestInterface $request): array;

    /**
     * @return array<string, string>
     */
    public function buildHeaders(ApiRequestInterface $request): array;
}

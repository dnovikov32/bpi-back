<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import\Fetcher;

use App\Infrastructure\Fetcher\Request\BaseRequestBuilder;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;

final class RequestBuilder extends BaseRequestBuilder
{
    public function __construct(
        private readonly string $method,
        private readonly string $url,
        private readonly string $tinkoffApiToken,
    ) {
        parent::__construct($this->method, $this->url);
    }

    /**
     * @param Request $request
     *
     * @return array<string, string>
     */
    public function buildQuery(ApiRequestInterface $request): array
    {
        return [
            'figi' => $request->figi,
            'year' => $request->year,
        ];
    }

    /**
     * @return array<string, string>
     */
    public function buildHeaders(ApiRequestInterface $request): array
    {
        return [
            'Authorization' => sprintf('Bearer %s', $this->tinkoffApiToken),
        ];
    }
}

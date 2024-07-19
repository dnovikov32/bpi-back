<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher;

use App\Infrastructure\Fetcher\Exception\HttpRequestFailedException;
use App\Infrastructure\Fetcher\Response\ResponseInterface;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;

interface FetcherInterface
{
    /**
     * @throws HttpRequestFailedException
     */
    public function fetch(ApiRequestInterface $request): ResponseInterface;
}

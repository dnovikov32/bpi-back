<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher\Response;

use App\Infrastructure\Fetcher\Exception\TransformFailedException;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponseTransformerInterface
{
    /**
     * @throws TransformFailedException
     */
    public function transform(ResponseInterface $httpResponse, ApiRequestInterface $request): mixed;
}

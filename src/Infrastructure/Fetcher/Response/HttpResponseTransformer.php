<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher\Response;

use App\Infrastructure\Fetcher\Exception\TransformFailedException;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;

class HttpResponseTransformer implements ResponseTransformerInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly string $type,
        private readonly string $format
    ) {
    }

    public function transform(ResponseInterface $httpResponse, ApiRequestInterface $request): mixed
    {
        try {
            return $this->serializer->deserialize(
                (string) $httpResponse->getBody(),
                $this->type,
                $this->format
            );
        } catch (Exception $e) {
            throw new TransformFailedException(sprintf('Deserialization error: %s', $e->getMessage()), $e->getCode(), $e);
        }
    }
}

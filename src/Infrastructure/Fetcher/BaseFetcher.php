<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher;

use App\Infrastructure\Fetcher\Exception\HttpRequestFailedException;
use App\Infrastructure\Fetcher\Exception\TransformFailedException;
use App\Infrastructure\Fetcher\HttpClient\HttpClientInterface;
use App\Infrastructure\Fetcher\Response\ResponseInterface;
use App\Infrastructure\Fetcher\Response\ResponseTransformerInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class BaseFetcher implements FetcherInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly ResponseTransformerInterface $responseTransformer,
    ) {
    }

    /**
     * @throws TransformFailedException
     */
    public function fetch(ApiRequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->httpClient->sendRequest($request);

            return $this->responseTransformer->transform($response, $request);
        } catch (GuzzleException $e) {
            $context = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'request' => $request,
            ];

            if ($e instanceof RequestException && $e->getResponse()) {
                $context['response'] = $e->getResponse()->getBody();
            }

            $this->logger->error('Request error', $context);

            throw new HttpRequestFailedException($e->getMessage(), $e);
        }
    }
}

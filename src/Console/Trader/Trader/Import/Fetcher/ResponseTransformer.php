<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import\Fetcher;

use App\Console\Trader\Trader\Import\Dto\ImportTraderDto;
use App\Infrastructure\Fetcher\Exception\TransformFailedException;
use App\Infrastructure\Fetcher\Response\ResponseTransformerInterface;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use Throwable;

class ResponseTransformer implements ResponseTransformerInterface
{
    private const SEPARATOR = ';';
    private const FROM_ENCODING = 'CP1251';
    private const TO_ENCODING = 'UTF-8';

    /**
     * @param Request $request
     *
     * @throws TransformFailedException
     */
    public function transform(HttpResponseInterface $httpResponse, ApiRequestInterface $request): Response
    {
        try {
            $rows = $this->getResponseContentAsArray($httpResponse);
            $traders = [];

            foreach ($rows as $row) {
                $columns = array_filter(str_getcsv($row, self::SEPARATOR));

                if ($columns === []) {
                    continue;
                }

                $traders[] = new ImportTraderDto(
                    year: $request->year,
                    id: (int) $columns[1],
                    name: mb_convert_encoding($columns[0], self::TO_ENCODING, self::FROM_ENCODING),
                );
            }

            return new Response($traders);
        } catch (Throwable $e) {
            throw new TransformFailedException(sprintf('Deserialization error: %s', $e->getMessage()), $e->getCode(), $e);
        }
    }

    /**
     * @return string[]
     */
    private function getResponseContentAsArray(HttpResponseInterface $httpResponse): array
    {
        return explode(PHP_EOL, (string) $httpResponse->getBody());
    }
}

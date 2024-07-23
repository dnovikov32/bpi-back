<?php

declare(strict_types=1);

namespace App\Console\Trader\Result\Import\Fetcher;

use App\Console\Trader\Result\Import\Dto\ImportResultDto;
use App\Infrastructure\Fetcher\Exception\TransformFailedException;
use App\Infrastructure\Fetcher\Response\ResponseTransformerInterface;
use DateTimeImmutable;
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
            $results = [];

            foreach ($rows as $row) {
                $columns = str_getcsv($row, self::SEPARATOR);

                if (!isset($columns[1])) {
                    continue;
                }

                $results[] = new ImportResultDto(
                    year: $request->year,
                    relevantDate: $this->transformToDatetime($columns[0]),
                    traderMoexId: (int) $columns[1],
                    traderName: $this->convertEncoding($columns[3]),
                    marketName: $this->convertEncoding($columns[2]),
                    brokerName: $this->convertEncoding($columns[4]),
                    startDate: $this->transformToDatetime($columns[6]),
                    profitPercentage: (float) $columns[7],
                    initialCapital: (float) $columns[8],
                    profit: (float) $columns[9],
                    dealCount: (int) ($columns[10] ?? 0),
                    volume: (float) ($columns[12] ?? 0),
                    active: (bool) ($columns[13] ?? false),
                );
            }

            return new Response($results);
        } catch (Throwable $e) {
            throw new TransformFailedException(sprintf('Deserialization error: %s', $e->getMessage()), $e->getCode(), $e);
        }
    }

    /**
     * @return string[]
     */
    private function getResponseContentAsArray(HttpResponseInterface $httpResponse): array
    {
        $rows = explode(PHP_EOL, (string) $httpResponse->getBody());
        array_shift($rows);

        return $rows;
    }

    private function transformToDatetime(string $date): DateTimeImmutable
    {
        return (DateTimeImmutable::createFromFormat('d.m.Y', $date))->setTime(0, 0);
    }

    private function convertEncoding(string $string): string
    {
        return mb_convert_encoding($string, self::TO_ENCODING, self::FROM_ENCODING);
    }
}

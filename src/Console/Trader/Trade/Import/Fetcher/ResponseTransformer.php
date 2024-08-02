<?php

declare(strict_types=1);

namespace App\Console\Trader\Trade\Import\Fetcher;

use App\Console\Trader\Trade\Import\Dto\ImportTradeDto;
use App\Infrastructure\Common\File\FileHelper;
use App\Infrastructure\Fetcher\Exception\TransformFailedException;
use App\Infrastructure\Fetcher\Response\ResponseTransformerInterface;
use DateTimeImmutable;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use Throwable;

/**
 * TODO: decompose to messenger and pipeline steps
 */
class ResponseTransformer implements ResponseTransformerInterface
{
    public function __construct(
        private readonly FileHelper $fileHelper,
        private readonly string $tempDir,
    ) {
    }

    /**
     * @param Request $request
     *
     * @throws TransformFailedException
     */
    public function transform(HttpResponseInterface $httpResponse, ApiRequestInterface $request): Response
    {
        try {
            $fileName = sprintf('%s_%s', $request->marketType->value(), $request->traderMoexId);
            $zipFilePath = sprintf('%s/%s.zip', $this->tempDir, $fileName);
            $cvsFilePath = sprintf('%s/%s.csv', $this->tempDir, $fileName);

            $this->fileHelper->saveContentToFile($httpResponse->getBody()->getContents(), $zipFilePath);
            $this->fileHelper->unzipFile($zipFilePath);
            $rows = $this->fileHelper->getCsvFileContentAsArray($cvsFilePath);
            $this->fileHelper->removeFiles([$zipFilePath, $cvsFilePath]);

            $trades = $this->transformRowsToDtoList($rows, $request);

            return new Response($trades);
        } catch (Throwable $e) {
            throw new TransformFailedException(sprintf('Deserialization error: %s', $e->getMessage()), $e->getCode(), $e);
        }
    }

    /**
     * @param string[] $rows
     *
     * @return ImportTradeDto[]
     */
    private function transformRowsToDtoList(array $rows, Request $request): array
    {
        $trades = [];

        foreach ($rows as $row) {
            $columns = str_getcsv($row, FileHelper::CSV_DEFAULT_SEPARATOR);

            $trades[] = new ImportTradeDto(
                year: $request->year,
                traderMoexId: $request->traderMoexId,
                marketType: $request->marketType,
                dateTime: DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $columns[0]),
                ticker: (string) $columns[1],
                volume: (int) $columns[2],
                price: (float) $columns[3],
            );
        }

        return $trades;
    }
}

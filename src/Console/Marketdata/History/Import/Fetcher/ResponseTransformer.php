<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import\Fetcher;

use App\Console\Marketdata\History\Import\Dto\ImportCandleDto;
use App\Infrastructure\Fetcher\Exception\TransformFailedException;
use App\Infrastructure\Fetcher\Response\ResponseTransformerInterface;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use FilesystemIterator;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SplFileInfo;
use Throwable;
use ZipArchive;

/**
 * TODO: decompose
 */
class ResponseTransformer implements ResponseTransformerInterface
{
    private const SEPARATOR = ';';

    public function __construct(
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
            $zipFilePath = $this->saveResponseContentToZipFile($httpResponse, $request);
            $unzipDir = $this->unzipFileToDirectory($zipFilePath);
            $cvsFiles = $this->getDirectoryFileList($unzipDir);
            $candles = [];

            foreach ($cvsFiles as $cvsFilePath) {
                $rows = $this->getCsvFileContentAsArray($cvsFilePath);
                $candles = [...$candles, ...$this->transformRowsToDtoList($rows)];
            }

            $this->removeTempFiles($cvsFiles, $zipFilePath, $unzipDir);

            return new Response($candles);
        } catch (Throwable $e) {
            throw new TransformFailedException(sprintf('Deserialization error: %s', $e->getMessage()), $e->getCode(), $e);
        }
    }

    /**
     * @param Request $request
     */
    private function saveResponseContentToZipFile(HttpResponseInterface $httpResponse, ApiRequestInterface $request): string
    {
        $this->createDirectory($this->tempDir);

        $zipFilePath = sprintf('%s/%s_%s.zip', $this->tempDir, $request->year, $request->figi);
        file_put_contents($zipFilePath, (string) $httpResponse->getBody());

        return $zipFilePath;
    }

    /**
     * @throws TransformFailedException
     */
    private function unzipFileToDirectory(string $zipFilePath): string
    {
        $zip = new ZipArchive();
        $result = $zip->open($zipFilePath);

        if ($result !== true) {
            throw new TransformFailedException(sprintf('Failed to open zip file %s', $zipFilePath));
        }

        $unzipDir = sprintf('%s/%s/', $this->tempDir, pathinfo($zipFilePath, PATHINFO_FILENAME));
        $this->createDirectory($unzipDir);

        $zip->extractTo($unzipDir);
        $zip->close();

        return $unzipDir;
    }

    private function createDirectory(string $dir): void
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    /**
     * @return array<int, string>
     */
    private function getDirectoryFileList(string $dir): array
    {
        $fileSystemIterator = new FilesystemIterator($dir);
        $files = [];

        /** @var SplFileInfo $fileInfo */
        foreach ($fileSystemIterator as $fileInfo) {
            $files[] = $fileInfo->getPathname();
        }

        asort($files);

        return $files;
    }

    /**
     * @return string[]
     */
    private function getCsvFileContentAsArray(string $filePath): array
    {
        $rows = explode(PHP_EOL, file_get_contents($filePath));

        return array_filter($rows);
    }

    /**
     * @param string[] $rows
     *
     * @return ImportCandleDto[]
     */
    private function transformRowsToDtoList(array $rows): array
    {
        $candles = [];

        foreach ($rows as $row) {
            $columns = str_getcsv($row, self::SEPARATOR);

            $candles[] = new ImportCandleDto(
                instrumentUid: $columns[0],
                startDate: $columns[1],
                openPrice: (float) $columns[2],
                closePrice: (float) $columns[3],
                maxPrice: (float) $columns[4],
                minPrice: (float) $columns[5],
                volume: (int) $columns[6],
            );
        }

        return $candles;
    }

    private function removeTempFiles(array $cvsFiles, string $zipFilePath, string $unzipDir): void
    {
        array_map('unlink', $cvsFiles);
        unlink($zipFilePath);
        rmdir($unzipDir);
    }
}

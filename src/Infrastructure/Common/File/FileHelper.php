<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\File;

use Exception;
use ZipArchive;

final class FileHelper
{
    public const CSV_DEFAULT_SEPARATOR = ';';

    public function createDirectory(string $directoryPath): void
    {
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }
    }

    public function saveContentToFile(string $content, string $filePath): string
    {
        $directoryPath = pathinfo($filePath, PATHINFO_DIRNAME);
        $this->createDirectory($directoryPath);
        file_put_contents($filePath, $content);

        return $filePath;
    }

    /**
     * @throws Exception
     */
    public function unzipFile(string $zipFilePath, string $targetDirectory = ''): string
    {
        $zip = new ZipArchive();
        $result = $zip->open($zipFilePath);

        if ($result !== true) {
            throw new Exception(sprintf('Failed to open zip file %s', $zipFilePath));
        }

        if ($targetDirectory === '') {
            $targetDirectory = pathinfo($zipFilePath, PATHINFO_DIRNAME);
        }

        $this->createDirectory($targetDirectory);

        $zip->extractTo($targetDirectory);
        $zip->close();

        return $targetDirectory;
    }

    /**
     * @return string[]
     */
    public function getCsvFileContentAsArray(string $filePath): array
    {
        $rows = explode(PHP_EOL, file_get_contents($filePath));

        return array_filter($rows);
    }

    /**
     * @param string[] $filePaths
     */
    public function removeFiles(array $filePaths): void
    {
        foreach ($filePaths as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}

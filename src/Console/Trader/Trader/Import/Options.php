<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import;

use App\Common\Importer\ImportOptionsInterface;
use Symfony\Component\Console\Helper\ProgressBar;

final class Options implements ImportOptionsInterface
{
    public function __construct(
        private readonly string $year,
        private readonly string $fileName,
        private readonly ?ProgressBar $progressBar,
    ) {
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getProgressBar(): ?ProgressBar
    {
        return $this->progressBar;
    }
}

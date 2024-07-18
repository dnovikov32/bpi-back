<?php

declare(strict_types=1);

namespace App\Console\Share\Import;

use App\Common\Importer\ImportOptionsInterface;
use Symfony\Component\Console\Helper\ProgressBar;

final class Options implements ImportOptionsInterface
{
    public function __construct(
        private readonly int $instrumentStatus,
        private readonly ?ProgressBar $progressBar,
    ) {
    }

    public function getInstrumentStatus(): int
    {
        return $this->instrumentStatus;
    }

    public function getProgressBar(): ?ProgressBar
    {
        return $this->progressBar;
    }
}

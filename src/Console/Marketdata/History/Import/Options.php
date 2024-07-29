<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import;

use App\Common\Importer\ImportOptionsInterface;
use Symfony\Component\Console\Helper\ProgressBar;

final class Options implements ImportOptionsInterface
{
    public function __construct(
        public readonly string $figi,
        public readonly int $year,
        public readonly ?ProgressBar $progressBar,
    ) {
    }
}

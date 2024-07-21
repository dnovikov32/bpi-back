<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import;

use App\Common\Importer\ImportOptionsInterface;
use Symfony\Component\Console\Helper\ProgressBar;

final class Options implements ImportOptionsInterface
{
    public function __construct(
        public readonly string $year,
        public readonly ?ProgressBar $progressBar,
    ) {
    }
}

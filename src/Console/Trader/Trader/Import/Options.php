<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import;

use App\Common\Importer\ImportOptionsInterface;

final class Options implements ImportOptionsInterface
{
    public function __construct(
        public readonly int $year
    ) {
    }
}

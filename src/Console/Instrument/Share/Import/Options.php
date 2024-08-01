<?php

declare(strict_types=1);

namespace App\Console\Instrument\Share\Import;

use App\Common\Importer\ImportOptionsInterface;

final class Options implements ImportOptionsInterface
{
    public function __construct(
        public readonly int $instrumentStatus,
    ) {
    }
}

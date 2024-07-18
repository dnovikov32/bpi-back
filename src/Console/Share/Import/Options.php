<?php

declare(strict_types=1);

namespace App\Console\Share\Import;

use App\Common\Importer\ImportOptionsInterface;

final class Options implements ImportOptionsInterface
{
    public function __construct(
        private readonly int $instrumentStatus
    ) {
    }

    public function getInstrumentStatus(): int
    {
        return $this->instrumentStatus;
    }
}

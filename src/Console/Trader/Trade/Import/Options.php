<?php

declare(strict_types=1);

namespace App\Console\Trader\Trade\Import;

use App\Common\Importer\ImportOptionsInterface;
use App\Domain\Trader\Enum\MarketType;

final class Options implements ImportOptionsInterface
{
    public function __construct(
        public readonly int $year,
        public readonly int $traderMoexId,
        public readonly MarketType $marketType,
    ) {
    }
}

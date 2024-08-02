<?php

declare(strict_types=1);

namespace App\Console\Trader\Trade\Import\Dto;

use App\Domain\Trader\Enum\MarketType;
use DateTimeImmutable;

final class ImportTradeDto
{
    public function __construct(
        public readonly int $year,
        public readonly int $traderMoexId,
        public readonly MarketType $marketType,
        public readonly DateTimeImmutable $dateTime,
        public readonly string $ticker,
        public readonly int $volume,
        public readonly float $price,
    ) {
    }
}

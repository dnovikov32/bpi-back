<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import\Dto;

use DateTimeImmutable;

final class ImportCandleDto
{
    public function __construct(
        public readonly string $instrumentUid,
        public readonly string $startDate,
        public readonly float $openPrice,
        public readonly float $closePrice,
        public readonly float $maxPrice,
        public readonly float $minPrice,
        public readonly int $volume,
    ) {
    }
}

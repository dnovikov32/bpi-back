<?php

declare(strict_types=1);

namespace App\Console\Trader\Result\Import\Dto;

use DateTimeImmutable;

final class ImportResultDto
{
    public function __construct(
        public readonly int $year,
        public readonly DateTimeImmutable $relevantDate,
        public readonly int $traderMoexId,
        public readonly string $traderName,
        public readonly string $marketName,
        public readonly string $brokerName,
        public readonly DateTimeImmutable $startDate,
        public readonly float $profitPercentage,
        public readonly float $initialCapital,
        public readonly float $profit,
        public readonly int $dealCount,
        public readonly float $volume,
        public readonly bool $active,
    ) {
    }
}

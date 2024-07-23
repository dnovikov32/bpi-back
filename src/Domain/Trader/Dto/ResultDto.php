<?php

declare(strict_types=1);

namespace App\Domain\Trader\Dto;

use App\Domain\Trader\Enum\MarketType;
use App\Domain\Trader\Model\Broker;
use App\Domain\Trader\Model\Trader;
use DateTimeImmutable;

final class ResultDto
{
    public function __construct(
        public readonly Trader $trader,
        public readonly Broker $broker,
        public readonly DateTimeImmutable $relevantDate,
        public readonly DateTimeImmutable $startDate,
        public readonly MarketType $marketType,
        public readonly float $initialCapital,
        public readonly float $profit,
        public readonly float $profitPercentage,
        public readonly int $dealCount,
        public readonly float $volume,
        public readonly bool $active,
    ) {
    }
}

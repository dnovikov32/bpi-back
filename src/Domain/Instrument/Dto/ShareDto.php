<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Dto;

use DateTimeImmutable;

final class ShareDto
{
    public function __construct(
        public readonly string $figi,
        public readonly string $ticker,
        public readonly string $isin,
        public readonly int $lot,
        public readonly string $currency,
        public readonly string $name,
        public readonly string $uid,
        public readonly ?DateTimeImmutable $first1minCandleDate,
        public readonly ?DateTimeImmutable $first1dayCandleDate,
    ) {
    }
}

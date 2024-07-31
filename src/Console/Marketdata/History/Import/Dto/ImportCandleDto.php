<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import\Dto;

final class ImportCandleDto
{
    public function __construct(
        public readonly string $instrumentUid,
        public readonly string $dateTime,
        public readonly float $open,
        public readonly float $close,
        public readonly float $high,
        public readonly float $low,
        public readonly int $volume,
    ) {
    }
}

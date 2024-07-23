<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import\Dto;

final class ImportTraderDto
{
    public function __construct(
        public readonly int $year,
        public readonly int $id,
        public readonly string $name,
    ) {
    }
}

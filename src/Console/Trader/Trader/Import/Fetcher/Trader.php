<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import\Fetcher;

final class Trader
{
    public function __construct(
        public readonly int $year,
        public readonly int $id,
        public readonly string $name,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Marketdata\Repository;

use App\Domain\Marketdata\Entity\Candle;

interface CandleRepositoryInterface
{
    public function save(Candle $candle): void;
}

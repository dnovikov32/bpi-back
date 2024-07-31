<?php

declare(strict_types=1);

namespace App\Domain\Trader\Repository;

use App\Domain\Trader\Entity\Trade;

interface TradeRepositoryInterface
{
    public function save(Trade $trader): void;
}

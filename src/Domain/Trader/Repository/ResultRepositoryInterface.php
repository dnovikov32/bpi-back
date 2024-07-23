<?php

declare(strict_types=1);

namespace App\Domain\Trader\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Entity\Result;

interface ResultRepositoryInterface
{
    public function save(Result $result): void;

    /**
     * @throws EntityNotFoundException
     */
    public function findByTraderIdAndMarketType(string $traderId, int $marketType): Result;
}

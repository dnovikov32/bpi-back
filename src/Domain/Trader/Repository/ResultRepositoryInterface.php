<?php

declare(strict_types=1);

namespace App\Domain\Trader\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Model\Result;

interface ResultRepositoryInterface
{
    public function save(Result $result): void;

    /**
     * @throws EntityNotFoundException
     */
    public function findByYearAndTraderIdAndMarketType(int $year, int $traderId, int $marketType): Result;
}

<?php

declare(strict_types=1);

namespace App\Domain\Trader\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Model\Trader;

interface TraderRepositoryInterface
{
    public function save(Trader $trader): void;

    /**
     * @throws EntityNotFoundException
     */
    public function findByYearAndMoexId(string $year, int $moexId): Trader;
}

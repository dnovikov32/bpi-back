<?php

declare(strict_types=1);

namespace App\Domain\Trader\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Entity\Trader;

interface TraderRepositoryInterface
{
    public function save(Trader $trader): void;

    /**
     * @throws EntityNotFoundException
     */
    public function findByYearAndMoexId(int $year, int $moexId): Trader;
}

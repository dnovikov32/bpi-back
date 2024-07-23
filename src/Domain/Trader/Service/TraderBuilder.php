<?php

declare(strict_types=1);

namespace App\Domain\Trader\Service;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Factory\TraderFactory;
use App\Domain\Trader\Entity\Trader;
use App\Domain\Trader\Repository\TraderRepositoryInterface;

final class TraderBuilder
{
    public function __construct(
        private readonly TraderRepositoryInterface $traderRepository,
        private readonly TraderFactory $traderFactory,
    ) {
    }

    public function findOrCreate(int $year, int $moexId, string $name): Trader
    {
        try {
            $trader = $this->traderRepository->findByYearAndMoexId($year, $moexId);
        } catch (EntityNotFoundException) {
            $trader = $this->traderFactory->create($year, $moexId, $name);
        }

        return $trader;
    }

    public function updateOrCreate(int $year, int $moexId, string $name): Trader
    {
        try {
            $trader = $this->traderRepository->findByYearAndMoexId($year, $moexId);
            $trader->update($year, $moexId, $name);
        } catch (EntityNotFoundException) {
            $trader = $this->traderFactory->create($year, $moexId, $name);
        }

        return $trader;
    }
}

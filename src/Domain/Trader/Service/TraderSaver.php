<?php

declare(strict_types=1);

namespace App\Domain\Trader\Service;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Model\Trader;
use App\Domain\Trader\Repository\TraderRepositoryInterface;

final class TraderSaver
{
    public function __construct(
        private readonly TraderRepositoryInterface $traderRepository,
    ) {
    }

    public function create(Trader $trader): void
    {
        $this->traderRepository->save($trader);
    }

    public function updateOrCreate(Trader $trader): void
    {
        try {
            $existedTrader = $this->traderRepository->findByMoexIdAndYear($trader->getMoexId(), $trader->getYear());
            $existedTrader->update($trader);
            $this->traderRepository->save($existedTrader);
        } catch (EntityNotFoundException) {
            $this->create($trader);
        }
    }
}

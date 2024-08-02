<?php

declare(strict_types=1);

namespace App\Domain\Trader\Service;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Enum\MarketType;
use App\Domain\Trader\Repository\TradeRepositoryInterface;
use App\Domain\Trader\Repository\TraderRepositoryInterface;

final class TradeDeleter
{
    public function __construct(
        private readonly TraderRepositoryInterface $traderRepository,
        private readonly TradeRepositoryInterface $tradeRepository,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function deleteAllByYearAndTraderMoexIdAndMarketType(
        int $year,
        int $traderMoexId,
        MarketType $marketType,
    ): void
    {
        $trader = $this->traderRepository->findByYearAndMoexId($year, $traderMoexId);

        $this->tradeRepository->deleteAllByTraderIdAndMarketType($trader->getId(), $marketType->value());
    }
}

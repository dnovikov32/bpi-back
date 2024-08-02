<?php

declare(strict_types=1);

namespace App\Console\Trader\Trade\Import\Builder;

use App\Console\Trader\Trade\Import\Dto\ImportTradeDto;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Enum\ClassCode;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;
use App\Domain\Trader\Entity\Trade;
use App\Domain\Trader\Factory\TradeFactory;
use App\Domain\Trader\Repository\TraderRepositoryInterface;

final class TradeBuilder
{
    public function __construct(
        private readonly TraderRepositoryInterface $traderRepository,
        private readonly ShareRepositoryInterface $shareRepository,
        private readonly TradeFactory $tradeFactory,
    ) {
    }

    /**
     * TODO: WTF TQBR and TQPI ???
     *
     * @throws EntityNotFoundException
     */
    public function create(ImportTradeDto $dto): Trade
    {
        $trader = $this->traderRepository->findByYearAndMoexId($dto->year, $dto->traderMoexId);

        try {
            $share = $this->shareRepository->findByTickerAndClassCode($dto->ticker, ClassCode::TQBR);
        } catch (EntityNotFoundException) {
            $share = $this->shareRepository->findByTickerAndClassCode($dto->ticker, ClassCode::TQPI);
        }

        return $this->tradeFactory->create(
            trader: $trader,
            share: $share,
            marketType: $dto->marketType,
            dateTime: $dto->dateTime,
            price: $dto->price,
            volume: $dto->volume,
        );
    }
}

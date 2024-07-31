<?php

declare(strict_types=1);

namespace App\Domain\Trader\Factory;

use App\Domain\Common\Service\IdService;
use App\Domain\Instrument\Entity\Share;
use App\Domain\Trader\Entity\Trade;
use App\Domain\Trader\Entity\Trader;
use App\Domain\Trader\Enum\MarketType;
use DateTimeImmutable;

final class TradeFactory
{
    public function __construct(
        private readonly IdService $idService
    ) {
    }

    public function create(
        Trader $trader,
        Share $share,
        MarketType $marketType,
        DateTimeImmutable $dateTime,
        float $price,
        int $volume,
    ): Trade
    {
        return new Trade(
            id: $this->idService->generate(),
            trader: $trader,
            share: $share,
            marketType: $marketType->value(),
            dateTime: $dateTime,
            price: $price,
            volume: $volume,
        );
    }
}

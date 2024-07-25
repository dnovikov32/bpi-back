<?php

declare(strict_types=1);

namespace App\Domain\Marketdata\Factory;

use App\Domain\Common\Service\IdService;
use App\Domain\Instrument\Entity\Share;
use App\Domain\Marketdata\Entity\Candle;
use DateTimeImmutable;

final class CandleFactory
{
    public function __construct(
        private readonly IdService $idService
    ) {
    }

    public function create(
        Share $share,
        DateTimeImmutable $startDate,
        float $openPrice,
        float $closePrice,
        float $maxPrice,
        float $minPrice,
        int $volume,
    ): Candle
    {
        return new Candle(
            id: $this->idService->generate(),
            share: $share,
            startDate: $startDate,
            openPrice: $openPrice,
            closePrice: $closePrice,
            maxPrice: $maxPrice,
            minPrice: $minPrice,
            volume: $volume,
        );
    }
}

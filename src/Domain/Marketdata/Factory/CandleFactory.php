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
        DateTimeImmutable $dateTime,
        float $open,
        float $close,
        float $high,
        float $low,
        int $volume,
    ): Candle
    {
        return new Candle(
            id: $this->idService->generate(),
            share: $share,
            dateTime: $dateTime,
            open: $open,
            close: $close,
            high: $high,
            low: $low,
            volume: $volume,
        );
    }
}

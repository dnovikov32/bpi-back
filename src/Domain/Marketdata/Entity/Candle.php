<?php

declare(strict_types=1);

namespace App\Domain\Marketdata\Entity;

use App\Domain\Instrument\Entity\Share;
use DateTimeImmutable;

/**
 * TODO: How to remove dependency on Instrument module (Share $share)?
 */
class Candle
{
    public function __construct(
        private string $id,
        private Share $share,
        private DateTimeImmutable $startDate,
        private float $openPrice,
        private float $closePrice,
        private float $maxPrice,
        private float $minPrice,
        private int $volume,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getShare(): Share
    {
        return $this->share;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getOpenPrice(): float
    {
        return $this->openPrice;
    }

    public function getClosePrice(): float
    {
        return $this->closePrice;
    }

    public function getMaxPrice(): float
    {
        return $this->maxPrice;
    }

    public function getMinPrice(): float
    {
        return $this->minPrice;
    }

    public function getVolume(): int
    {
        return $this->volume;
    }
}

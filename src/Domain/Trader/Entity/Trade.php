<?php

declare(strict_types=1);

namespace App\Domain\Trader\Entity;

use App\Domain\Instrument\Entity\Share;
use DateTimeImmutable;

class Trade
{
    public function __construct(
        private string $id,
        private Trader $trader,
        private Share $share,
        private int $marketType,
        private DateTimeImmutable $dateTime,
        private float $price,
        private int $volume,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTrader(): Trader
    {
        return $this->trader;
    }

    public function getShare(): Share
    {
        return $this->share;
    }

    public function getMarketType(): int
    {
        return $this->marketType;
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getVolume(): int
    {
        return $this->volume;
    }
}

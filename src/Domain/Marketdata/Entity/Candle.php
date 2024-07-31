<?php

declare(strict_types=1);

namespace App\Domain\Marketdata\Entity;

use App\Domain\Common\Entity\EntityInterface;
use App\Domain\Instrument\Entity\Share;
use DateTimeImmutable;

/**
 * TODO: How to remove dependency on Instrument module (Share $share)?
 */
class Candle implements EntityInterface
{
    public function __construct(
        private readonly string $id,
        private readonly Share $share,
        private readonly DateTimeImmutable $dateTime,
        private readonly float $open,
        private readonly float $close,
        private readonly float $high,
        private readonly float $low,
        private readonly int $volume,
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

    public function getDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function getOpen(): float
    {
        return $this->open;
    }

    public function getClose(): float
    {
        return $this->close;
    }

    public function getHigh(): float
    {
        return $this->high;
    }

    public function getLow(): float
    {
        return $this->low;
    }

    public function getVolume(): int
    {
        return $this->volume;
    }
}

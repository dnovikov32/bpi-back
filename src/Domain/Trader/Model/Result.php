<?php

declare(strict_types=1);

namespace App\Domain\Trader\Model;

use App\Domain\Trader\Dto\ResultDto;
use DateTimeImmutable;

class Result
{
    public function __construct(
        private string $id,
        private Trader $trader,
        private Broker $broker,
        private DateTimeImmutable $relevantDate,
        private DateTimeImmutable $startDate,
        private int $marketType,
        private float $initialCapital,
        private float $profit,
        private float $profitPercentage,
        private int $dealCount,
        private float $volume,
        private bool $active,
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

    public function getBroker(): Broker
    {
        return $this->broker;
    }

    public function getRelevantDate(): DateTimeImmutable
    {
        return $this->relevantDate;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getMarketType(): int
    {
        return $this->marketType;
    }

    public function getInitialCapital(): float
    {
        return $this->initialCapital;
    }

    public function getProfit(): float
    {
        return $this->profit;
    }

    public function getProfitPercentage(): float
    {
        return $this->profitPercentage;
    }

    public function getDealCount(): int
    {
        return $this->dealCount;
    }

    public function getVolume(): float
    {
        return $this->volume;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function update(ResultDto $resultDto): Result
    {
        $this->trader = $resultDto->trader;
        $this->broker = $resultDto->broker;
        $this->relevantDate = $resultDto->relevantDate;
        $this->startDate = $resultDto->startDate;
        $this->marketType = $resultDto->marketType->value();
        $this->initialCapital = $resultDto->initialCapital;
        $this->profit = $resultDto->profit;
        $this->profitPercentage = $resultDto->profitPercentage;
        $this->dealCount = $resultDto->dealCount;
        $this->volume = $resultDto->volume;
        $this->active = $resultDto->active;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Trader\Model;

use DateTimeImmutable;

final class Result
{
    public function __construct(
        private string $id,
        private int $year,
        private int $traderId,
        private int $marketType,
        private DateTimeImmutable $relevantDate,
        private DateTimeImmutable $startDate,
        private string $brokerId,
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

    public function getYear(): int
    {
        return $this->year;
    }

    public function getTraderId(): int
    {
        return $this->traderId;
    }

    public function getMarketType(): int
    {
        return $this->marketType;
    }

    public function getRelevantDate(): DateTimeImmutable
    {
        return $this->relevantDate;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getBrokerId(): string
    {
        return $this->brokerId;
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

    public function update(Result $result): Result
    {
        $this->year = $result->getYear();
        $this->traderId = $result->getTraderId();
        $this->marketType = $result->getMarketType();
        $this->relevantDate = $result->getRelevantDate();
        $this->startDate = $result->getStartDate();
        $this->brokerId = $result->getBrokerId();
        $this->initialCapital = $result->getInitialCapital();
        $this->profit = $result->getProfit();
        $this->profitPercentage = $result->getProfitPercentage();
        $this->dealCount = $result->getDealCount();
        $this->volume = $result->getVolume();
        $this->active = $result->getActive();

        return $this;
    }
}

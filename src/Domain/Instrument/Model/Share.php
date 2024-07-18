<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Model;

use DateTimeImmutable;

final class Share
{
    public function __construct(
        private string $id,
        private string $figi,
        private string $ticker,
        private string $isin,
        private int $lot,
        private string $currency,
        private string $name,
        private string $uid,
        private ?DateTimeImmutable $first1minCandleDate,
        private ?DateTimeImmutable $first1dayCandleDate,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFigi(): string
    {
        return $this->figi;
    }

    public function getTicker(): string
    {
        return $this->ticker;
    }

    public function getIsin(): string
    {
        return $this->isin;
    }

    public function getLot(): int
    {
        return $this->lot;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getFirst1minCandleDate(): ?DateTimeImmutable
    {
        return $this->first1minCandleDate;
    }

    public function getFirst1dayCandleDate(): ?DateTimeImmutable
    {
        return $this->first1dayCandleDate;
    }

    public function update(Share $share): Share
    {
        $this->figi = $share->getFigi();
        $this->ticker = $share->getTicker();
        $this->isin = $share->getIsin();
        $this->lot = $share->getLot();
        $this->currency = $share->getCurrency();
        $this->name = $share->getName();
        $this->uid = $share->getUid();
        $this->name = $share->getName();
        $this->first1minCandleDate = $share->getFirst1minCandleDate();
        $this->first1dayCandleDate = $share->getFirst1dayCandleDate();

        return $this;
    }
}

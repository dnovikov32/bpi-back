<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Model;

use App\Domain\Common\Service\IdService;
use DateTimeImmutable;

final class Share
{
    private readonly string $id;

    public function __construct(
        private readonly string $figi,
        private readonly string $ticker,
        private readonly string $isin,
        private readonly int $lot,
        private readonly string $currency,
        private readonly string $name,
        private readonly string $uid,
        private readonly ?DateTimeImmutable $first1minCandleDate,
        private readonly ?DateTimeImmutable $first1dayCandleDate,
    ) {
        $this->id = IdService::generate();
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
}

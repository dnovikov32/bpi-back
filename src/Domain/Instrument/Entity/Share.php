<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Entity;

use App\Domain\Common\Entity\EntityInterface;
use App\Domain\Instrument\Dto\ShareDto;
use DateTimeImmutable;

class Share implements EntityInterface
{
    public function __construct(
        private string $id,
        private string $figi,
        private string $ticker,
        private string $isin,
        private string $uid,
        private string $classCode,
        private int $lot,
        private string $currency,
        private string $name,
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

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getClassCode(): string
    {
        return $this->classCode;
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

    public function getFirst1minCandleDate(): ?DateTimeImmutable
    {
        return $this->first1minCandleDate;
    }

    public function getFirst1dayCandleDate(): ?DateTimeImmutable
    {
        return $this->first1dayCandleDate;
    }

    public function update(ShareDto $dto): Share
    {
        $this->figi = $dto->figi;
        $this->ticker = $dto->ticker;
        $this->isin = $dto->isin;
        $this->uid = $dto->uid;
        $this->classCode = $dto->classCode;
        $this->lot = $dto->lot;
        $this->currency = $dto->currency;
        $this->name = $dto->name;
        $this->first1minCandleDate = $dto->first1minCandleDate;
        $this->first1dayCandleDate = $dto->first1dayCandleDate;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Trader\Model;

final class Trader
{
    public function __construct(
        private string $id,
        private int $moexId,
        private string $name,
        private string $year,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMoexId(): int
    {
        return $this->moexId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function update(Trader $trader): Trader
    {
        $this->moexId = $trader->getMoexId();
        $this->name = $trader->getName();
        $this->year = $trader->getYear();

        return $this;
    }
}

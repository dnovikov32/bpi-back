<?php

declare(strict_types=1);

namespace App\Domain\Trader\Model;

final class Trader
{
    public function __construct(
        private string $id,
        private string $year,
        private int $moexId,
        private string $name,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function getMoexId(): int
    {
        return $this->moexId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function update(Trader $trader): Trader
    {
        $this->year = $trader->getYear();
        $this->moexId = $trader->getMoexId();
        $this->name = $trader->getName();

        return $this;
    }
}

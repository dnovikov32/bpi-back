<?php

declare(strict_types=1);

namespace App\Domain\Trader\Model;

class Trader
{
    public function __construct(
        private string $id,
        private int $year,
        private int $moexId,
        private string $name,
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

    public function getMoexId(): int
    {
        return $this->moexId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function update(int $year, int $moexId, string $name): Trader
    {
        $this->year = $year;
        $this->moexId = $moexId;
        $this->name = $name;

        return $this;
    }
}

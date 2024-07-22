<?php

declare(strict_types=1);

namespace App\Domain\Trader\Model;

final class Broker
{
    public function __construct(
        private string $id,
        private string $name,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function update(self $broker): self
    {
        $this->name = $broker->getName();

        return $this;
    }
}

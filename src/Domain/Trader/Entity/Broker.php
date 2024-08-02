<?php

declare(strict_types=1);

namespace App\Domain\Trader\Entity;

use App\Domain\Common\Entity\EntityInterface;

class Broker implements EntityInterface
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
}

<?php

declare(strict_types=1);

namespace App\Domain\Trader\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Entity\Broker;

interface BrokerRepositoryInterface
{
    public function save(Broker $broker): void;

    /**
     * @throws EntityNotFoundException
     */
    public function findByName(string $name): Broker;
}

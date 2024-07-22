<?php

declare(strict_types=1);

namespace App\Domain\Trader\Service;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Model\Broker;
use App\Domain\Trader\Repository\BrokerRepositoryInterface;

final class BrokerSaver
{
    public function __construct(
        private readonly BrokerRepositoryInterface $brokerRepository,
    ) {
    }

    public function create(Broker $broker): Broker
    {
        $this->brokerRepository->save($broker);

        return $broker;
    }

    public function findOrCreate(Broker $broker): Broker
    {
        try {
            return $this->brokerRepository->findByName($broker->getName());
        } catch (EntityNotFoundException) {
            return $this->create($broker);
        }
    }
}

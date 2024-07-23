<?php

declare(strict_types=1);

namespace App\Domain\Trader\Service;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Factory\BrokerFactory;
use App\Domain\Trader\Model\Broker;
use App\Domain\Trader\Repository\BrokerRepositoryInterface;

final class BrokerBuilder
{
    public function __construct(
        private readonly BrokerRepositoryInterface $brokerRepository,
        private readonly BrokerFactory $brokerFactory,
    ) {
    }

    public function findOrCreate(string $name): Broker
    {
        try {
            $broker = $this->brokerRepository->findByName($name);
        } catch (EntityNotFoundException) {
            $broker = $this->brokerFactory->create($name);
        }

        return $broker;
    }
}

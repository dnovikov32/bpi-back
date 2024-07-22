<?php

declare(strict_types=1);

namespace App\Domain\Trader\Factory;

use App\Domain\Common\Service\IdService;
use App\Domain\Trader\Model\Broker;

final class BrokerFactory
{
    public function __construct(
        private readonly IdService $idService
    ) {
    }

    public function create(
        string $name,
    ): Broker
    {
        return new Broker(
            id: $this->idService->generate(),
            name: $name,
        );
    }
}

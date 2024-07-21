<?php

declare(strict_types=1);

namespace App\Domain\Trader\Factory;

use App\Domain\Common\Service\IdService;
use App\Domain\Trader\Model\Trader;

final class TraderFactory
{
    public function __construct(
        private readonly IdService $idService
    ) {
    }

    public function create(
        int $year,
        int $moexId,
        string $name,
    ): Trader
    {
        return new Trader(
            id: $this->idService->generate(),
            year: $year,
            moexId: $moexId,
            name: $name,
        );
    }
}

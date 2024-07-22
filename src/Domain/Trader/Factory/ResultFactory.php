<?php

declare(strict_types=1);

namespace App\Domain\Trader\Factory;

use App\Domain\Common\Service\IdService;
use App\Domain\Trader\Model\Result;
use DateTimeImmutable;

final class ResultFactory
{
    public function __construct(
        private readonly IdService $idService
    ) {
    }

    public function create(
        int $year,
        int $traderId,
        int $marketType,
        DateTimeImmutable $relevantDate,
        DateTimeImmutable $startDate,
        string $brokerId,
        float $initialCapital,
        float $profit,
        float $profitPercentage,
        int $dealCount,
        float $volume,
        bool $active,
    ): Result
    {
        return new Result(
            id: $this->idService->generate(),
            year: $year,
            traderId: $traderId,
            marketType: $marketType,
            relevantDate: $relevantDate,
            startDate: $startDate,
            brokerId: $brokerId,
            initialCapital: $initialCapital,
            profit: $profit,
            profitPercentage: $profitPercentage,
            dealCount: $dealCount,
            volume: $volume,
            active: $active,
        );
    }
}

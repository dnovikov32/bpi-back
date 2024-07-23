<?php

declare(strict_types=1);

namespace App\Domain\Trader\Factory;

use App\Domain\Common\Service\IdService;
use App\Domain\Trader\Dto\ResultDto;
use App\Domain\Trader\Entity\Result;

final class ResultFactory
{
    public function __construct(
        private readonly IdService $idService
    ) {
    }

    public function create(ResultDto $dto): Result
    {
        return new Result(
            id: $this->idService->generate(),
            trader: $dto->trader,
            broker: $dto->broker,
            relevantDate: $dto->relevantDate,
            startDate: $dto->startDate,
            marketType: $dto->marketType->value(),
            initialCapital: $dto->initialCapital,
            profit: $dto->profit,
            profitPercentage: $dto->profitPercentage,
            dealCount: $dto->dealCount,
            volume: $dto->volume,
            active: $dto->active,
        );
    }
}

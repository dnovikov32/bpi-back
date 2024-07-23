<?php

declare(strict_types=1);

namespace App\Console\Trader\Result\Import\Builder;

use App\Console\Trader\Result\Import\Dto\ImportResultDto;
use App\Domain\Trader\Dto\ResultDto;
use App\Domain\Trader\Enum\MarketType;
use App\Domain\Trader\Entity\Result;
use App\Domain\Trader\Service\BrokerBuilder;
use App\Domain\Trader\Service\TraderBuilder;
use App\Domain\Trader\Service\ResultBuilder;

final class AggregateResultBuilder
{
    public function __construct(
        private readonly TraderBuilder $traderBuilder,
        private readonly BrokerBuilder $brokerBuilder,
        private readonly ResultBuilder $resultBuilder
    ) {
    }

    public function updateOrCreate(ImportResultDto $dto): Result
    {
        $trader = $this->traderBuilder->findOrCreate(
            year: $dto->year,
            moexId: $dto->traderMoexId,
            name: $dto->traderName
        );

        $broker = $this->brokerBuilder->findOrCreate($dto->brokerName);

        return $this->resultBuilder->updateOrCreate(
            new ResultDto(
                trader: $trader,
                broker: $broker,
                relevantDate: $dto->relevantDate,
                startDate: $dto->startDate,
                marketType: MarketType::from($dto->marketName),
                initialCapital: $dto->initialCapital,
                profit: $dto->profit,
                profitPercentage: $dto->profitPercentage,
                dealCount: $dto->dealCount,
                volume: $dto->volume,
                active: $dto->active,
            )
        );
    }
}

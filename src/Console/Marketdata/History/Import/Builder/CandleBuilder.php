<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import\Builder;

use App\Console\Marketdata\History\Import\Dto\ImportCandleDto;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;
use App\Domain\Marketdata\Entity\Candle;
use App\Domain\Marketdata\Factory\CandleFactory;

final class CandleBuilder
{
    public function __construct(
        private readonly ShareRepositoryInterface $shareRepository,
        private readonly CandleFactory $candleFactory,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function create(ImportCandleDto $dto): Candle
    {
        $share = $this->shareRepository->findByUid($dto->instrumentUid);

        return $this->candleFactory->create(
            share: $share,
            startDate: $dto->startDate,
            openPrice: $dto->openPrice,
            closePrice: $dto->closePrice,
            maxPrice: $dto->maxPrice,
            minPrice: $dto->minPrice,
            volume: $dto->volume,
        );
    }
}

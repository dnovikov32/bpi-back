<?php

declare(strict_types=1);

namespace App\Domain\Trader\Service;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Model\Result;
use App\Domain\Trader\Repository\ResultRepositoryInterface;

final class ResultSaver
{
    public function __construct(
        private readonly ResultRepositoryInterface $resultRepository,
    ) {
    }

    public function create(Result $result): void
    {
        $this->resultRepository->save($result);
    }

    public function updateOrCreate(Result $result): void
    {
        try {
            $existedResult = $this->resultRepository->findByYearAndTraderIdAndMarketType(
                year: $result->getYear(),
                traderId: $result->getTraderId(),
                marketType: $result->getMarketType()
            );
            $existedResult->update($result);
            $this->resultRepository->save($existedResult);
        } catch (EntityNotFoundException) {
            $this->create($result);
        }
    }
}

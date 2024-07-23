<?php

declare(strict_types=1);

namespace App\Domain\Trader\Service;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Factory\ResultFactory;
use App\Domain\Trader\Entity\Result;
use App\Domain\Trader\Repository\ResultRepositoryInterface;
use App\Domain\Trader\Dto\ResultDto;

final class ResultBuilder
{
    public function __construct(
        private readonly ResultRepositoryInterface $resultRepository,
        private readonly ResultFactory $resultFactory,
    ) {
    }

    public function updateOrCreate(ResultDto $dto): Result
    {
        try {
            $result = $this->resultRepository->findByTraderIdAndMarketType(
                traderId: $dto->trader->getId(),
                marketType: $dto->marketType->value()
            );

            $result->update($dto);
        } catch (EntityNotFoundException) {
            $result = $this->resultFactory->create($dto);
        }

        return $result;
    }
}

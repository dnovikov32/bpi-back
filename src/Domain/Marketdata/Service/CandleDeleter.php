<?php

declare(strict_types=1);

namespace App\Domain\Marketdata\Service;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;
use App\Domain\Marketdata\Repository\CandleRepositoryInterface;

final class CandleDeleter
{
    public function __construct(
        private readonly ShareRepositoryInterface $shareRepository,
        private readonly CandleRepositoryInterface $candleRepository,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function deleteAllByShareFigiAndYear(string $shareFigi, int $year): void
    {
        $share = $this->shareRepository->findByFigi($shareFigi);

        $this->candleRepository->deleteAllByShareIdAndYear($share->getId(), $year);
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Builder;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Dto\ShareDto;
use App\Domain\Instrument\Entity\Share;
use App\Domain\Instrument\Factory\ShareFactory;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;

final class ShareBuilder
{
    public function __construct(
        private readonly ShareRepositoryInterface $shareRepository,
        private readonly ShareFactory $shareFactory,
    ) {
    }

    public function updateOrCreate(ShareDto $dto): Share
    {
        try {
            $share = $this->shareRepository->findByTicker($dto->ticker);
            $share->update($dto);
        } catch (EntityNotFoundException) {
            $share = $this->shareFactory->create($dto);
        }

        return $share;
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Service;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Model\Share;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;

final class ShareSaver
{
    public function __construct(
        private readonly ShareRepositoryInterface $shareRepository,
    ) {
    }

    public function create(Share $share): void
    {
        $this->shareRepository->save($share);
    }

    public function updateOrCreate(Share $share): void
    {
        try {
            $existedShare = $this->shareRepository->findByTicker($share->getTicker());
            $existedShare->update($share);
            $this->shareRepository->save($existedShare);
        } catch (EntityNotFoundException) {
            $this->create($share);
        }
    }
}

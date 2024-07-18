<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Service;

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
}

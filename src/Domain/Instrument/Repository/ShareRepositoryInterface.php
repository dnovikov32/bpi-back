<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Repository;

use App\Domain\Instrument\Model\Share;

interface ShareRepositoryInterface
{
    public function save(Share $share): void;
}

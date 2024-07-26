<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Entity\Share;

interface ShareRepositoryInterface
{
    public function save(Share $share): void;

    /**
     * @throws EntityNotFoundException
     */
    public function findByTicker(string $ticker): Share;

    /**
     * @throws EntityNotFoundException
     */
    public function findByUid(string $uid): Share;

    /**
     * @throws EntityNotFoundException
     */
    public function findByFigi(string $figi): Share;
}

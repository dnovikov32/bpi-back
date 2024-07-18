<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Instrument\Model\Share;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ShareRepository extends ServiceEntityRepository implements ShareRepositoryInterface
{
    public function save(Share $share): void
    {
        $this->getEntityManager()->persist($share);
        $this->getEntityManager()->flush();
    }
}

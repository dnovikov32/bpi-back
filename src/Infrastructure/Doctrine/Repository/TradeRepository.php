<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Trader\Entity\Trade;
use App\Domain\Trader\Repository\TradeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class TradeRepository extends ServiceEntityRepository implements TradeRepositoryInterface
{
    public function save(Trade $trader): void
    {
        $this->getEntityManager()->persist($trader);
        $this->getEntityManager()->flush();
    }
}

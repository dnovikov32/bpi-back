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

    public function deleteAllByTraderIdAndMarketType(string $traderId, int $marketType): void
    {
        $this->createQueryBuilder('t')
            ->delete()
            ->andWhere('t.trader = :traderId')
            ->andWhere('t.marketType = :marketType')
            ->setParameters([
                ':traderId' => $traderId,
                ':marketType' => $marketType,
            ])
            ->getQuery()
            ->execute();
    }
}

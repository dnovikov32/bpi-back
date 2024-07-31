<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Marketdata\Entity\Candle;
use App\Domain\Marketdata\Repository\CandleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CandleRepository extends ServiceEntityRepository implements CandleRepositoryInterface
{
    public function save(Candle $candle): void
    {
        $this->getEntityManager()->persist($candle);
        $this->getEntityManager()->flush();
    }

    // TODO: add test
    public function deleteAllByShareIdAndYear(string $shareId, int $year): void
    {
        $this->createQueryBuilder('c')
            ->delete()
            ->andWhere('c.share = :shareId')
            ->andWhere("DATE_PART('year', c.dateTime) = :year")
            ->setParameters([
                ':shareId' => $shareId,
                ':year' => $year,
            ])
            ->getQuery()
            ->execute();
    }
}

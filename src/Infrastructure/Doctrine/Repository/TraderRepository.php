<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Model\Trader;
use App\Domain\Trader\Repository\TraderRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\UnexpectedResultException;

class TraderRepository extends ServiceEntityRepository implements TraderRepositoryInterface
{
    public function save(Trader $trader): void
    {
        $this->getEntityManager()->persist($trader);
        $this->getEntityManager()->flush();
    }

    public function findByYearAndMoexId(string $year, int $moexId): Trader
    {
        try {
            return $this->createQueryBuilder('t')
                ->andWhere('t.year = :year')
                ->andWhere('t.moexId = :modexId')
                ->setParameters([
                    ':year' => $year,
                    ':modexId' => $moexId,
                ])
                ->getQuery()
                ->getSingleResult();
        } catch (UnexpectedResultException $e) {
            throw new EntityNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }
}

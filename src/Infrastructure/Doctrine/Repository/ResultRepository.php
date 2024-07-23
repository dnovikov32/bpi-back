<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Model\Result;
use App\Domain\Trader\Repository\ResultRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\UnexpectedResultException;

class ResultRepository extends ServiceEntityRepository implements ResultRepositoryInterface
{
    public function save(Result $result): void
    {
        $this->getEntityManager()->persist($result);
        $this->getEntityManager()->flush();
    }

    public function findByTraderIdAndMarketType(string $traderId, int $marketType): Result
    {
        try {
            return $this->createQueryBuilder('r')
                ->andWhere('r.trader = :traderId') // IDENTITY
                ->andWhere('r.marketType = :marketType')
                ->setParameters([
                    ':traderId' => $traderId,
                    ':marketType' => $marketType,
                ])
                ->getQuery()
                ->getSingleResult();
        } catch (UnexpectedResultException $e) {
            throw new EntityNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }
}

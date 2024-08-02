<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Entity\Share;
use App\Domain\Instrument\Enum\ClassCode;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\UnexpectedResultException;

class ShareRepository extends ServiceEntityRepository implements ShareRepositoryInterface
{
    public function save(Share $share): void
    {
        $this->getEntityManager()->persist($share);
        $this->getEntityManager()->flush();
    }

    public function findByTickerAndClassCode(string $ticker, ClassCode $classCode): Share
    {
        try {
            return $this->createQueryBuilder('s')
                ->andWhere('s.ticker = :ticker')
                ->andWhere('s.classCode = :classCode')
                ->setParameters([
                    ':ticker' => $ticker,
                    ':classCode' => $classCode->value,
                ])
                ->getQuery()
                ->getSingleResult();
        } catch (UnexpectedResultException $e) {
            throw new EntityNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * TODO: add test
     */
    public function findByUid(string $uid): Share
    {
        try {
            return $this->createQueryBuilder('s')
                ->where('s.uid = :uid')
                ->setParameter(':uid', $uid)
                ->getQuery()
                ->getSingleResult();
        } catch (UnexpectedResultException $e) {
            throw new EntityNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * TODO: add test
     */
    public function findByFigi(string $figi): Share
    {
        try {
            return $this->createQueryBuilder('s')
                ->where('s.figi = :figi')
                ->setParameter(':figi', $figi)
                ->getQuery()
                ->getSingleResult();
        } catch (UnexpectedResultException $e) {
            throw new EntityNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }
}

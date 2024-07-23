<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Entity\Share;
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

    public function findByTicker(string $ticker): Share
    {
        try {
            return $this->createQueryBuilder('s')
                ->where('s.ticker = :ticker')
                ->setParameter(':ticker', $ticker)
                ->getQuery()
                ->getSingleResult();
        } catch (UnexpectedResultException $e) {
            throw new EntityNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }
}

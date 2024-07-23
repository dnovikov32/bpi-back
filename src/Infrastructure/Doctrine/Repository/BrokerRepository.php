<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Entity\Broker;
use App\Domain\Trader\Repository\BrokerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\UnexpectedResultException;

class BrokerRepository extends ServiceEntityRepository implements BrokerRepositoryInterface
{
    public function save(Broker $broker): void
    {
        $this->getEntityManager()->persist($broker);
        $this->getEntityManager()->flush();
    }

    public function findByName(string $name): Broker
    {
        try {
            return $this->createQueryBuilder('b')
                ->where('b.name = :name')
                ->setParameter(':name', $name)
                ->getQuery()
                ->getSingleResult();
        } catch (UnexpectedResultException $e) {
            throw new EntityNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }
}

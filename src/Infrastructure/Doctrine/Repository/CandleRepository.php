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
}

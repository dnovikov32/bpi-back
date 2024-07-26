<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\Common\Entity\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

final class BulkPersister
{
    /**
     * @var array<class-string, int>
     */
    private array $count = [];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly int $batchSize
    ){
    }

    public function persist(EntityInterface $entity): void
    {
        $this->entityManager->persist($entity);

        $class = get_class($entity);

        if (!isset($this->count[$class])) {
            $this->count[$class] = 0;
        }

        $this->count[$class]++;

        if ($this->count[$class] % $this->batchSize === 0) {
            $this->flushAndClear($class);
        }
    }

    /**
     * @param class-string $class
     */
    public function flushAndClear(string $class): void
    {
        $this->entityManager->flush();
        $this->entityManager->clear();

        $this->count[$class] = 0;
    }
}

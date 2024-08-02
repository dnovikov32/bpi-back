<?php

declare(strict_types=1);

namespace App\Console\Trader\Result\Import;

use App\Common\Importer\CountAwareTrait;
use App\Common\Importer\ImportOptionsInterface;
use App\Common\Importer\IterableImporterInterface;
use App\Console\Trader\Result\Import\Builder\AggregateResultBuilder;
use App\Console\Trader\Result\Import\Fetcher\Request;
use App\Console\Trader\Result\Import\Fetcher\Response;
use App\Domain\Trader\Entity\Broker;
use App\Domain\Trader\Entity\Result;
use App\Domain\Trader\Service\BrokerBuilder;
use App\Infrastructure\Doctrine\BulkPersister;
use App\Infrastructure\Fetcher\FetcherInterface;
use Generator;

/**
 * TODO: Failed to use bulk insertion. Problem with broker unique name.
 */
final class Importer implements IterableImporterInterface
{
    use CountAwareTrait;

    public function __construct(
        private readonly FetcherInterface $fetcher,
        private readonly BrokerBuilder $brokerBuilder,
        private readonly AggregateResultBuilder $aggregateResultBuilder,
        private readonly BulkPersister $bulkPersister,
    ) {
    }

    /**
     * @param Options $options
     */
    public function import(ImportOptionsInterface $options): Generator
    {
        $response = $this->fetchDataFromApi($options);
        $this->count = count($response->results);

        $this->saveAllBrokers($response->brokers);

        foreach ($response->results as $dto) {
            $result = $this->aggregateResultBuilder->updateOrCreate($dto);
            $this->bulkPersister->persist($result);

            yield;
        }

        $this->bulkPersister->flushAndClear(Result::class);
    }

    private function fetchDataFromApi(Options $options): Response
    {
        /** @var Response $response */
        $response = $this->fetcher->fetch(
            new Request($options->year)
        );

        return $response;
    }

    private function saveAllBrokers(array $brokers): void
    {
        foreach ($brokers as $brokerName) {
            $broker = $this->brokerBuilder->findOrCreate($brokerName);
            $this->bulkPersister->persist($broker);
        }

        $this->bulkPersister->flushAndClear(Broker::class);
    }
}

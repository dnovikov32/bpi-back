<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import;

use App\Common\Importer\CountAwareTrait;
use App\Common\Importer\ImportOptionsInterface;
use App\Common\Importer\IterableImporterInterface;
use App\Console\Trader\Trader\Import\Fetcher\Request;
use App\Console\Trader\Trader\Import\Fetcher\Response;
use App\Domain\Trader\Entity\Trader;
use App\Domain\Trader\Service\TraderBuilder;
use App\Infrastructure\Doctrine\BulkPersister;
use App\Infrastructure\Fetcher\FetcherInterface;
use Generator;

final class Importer implements IterableImporterInterface
{
    use CountAwareTrait;

    public function __construct(
        private readonly FetcherInterface $fetcher,
        private readonly TraderBuilder $traderBuilder,
        private readonly BulkPersister $bulkPersister,
    ) {
    }

    /**
     * @param Options $options
     */
    public function import(ImportOptionsInterface $options): Generator
    {
        $response = $this->fetchDataFromApi($options);
        $this->count = count($response->traders);

        foreach ($response->traders as $dto) {
            $trader = $this->traderBuilder->updateOrCreate($dto->year, $dto->id,  $dto->name);
            $this->bulkPersister->persist($trader);

            yield;
        }

        $this->bulkPersister->flushAndClear(Trader::class);
    }

    private function fetchDataFromApi(Options $options): Response
    {
        /** @var Response $response */
        $response = $this->fetcher->fetch(
            new Request($options->year)
        );

        return $response;
    }
}

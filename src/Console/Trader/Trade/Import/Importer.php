<?php

declare(strict_types=1);

namespace App\Console\Trader\Trade\Import;

use App\Common\Importer\CountAwareTrait;
use App\Common\Importer\ImportOptionsInterface;
use App\Common\Importer\IterableImporterInterface;
use App\Console\Trader\Trade\Import\Builder\TradeBuilder;
use App\Console\Trader\Trade\Import\Fetcher\Request;
use App\Console\Trader\Trade\Import\Fetcher\Response;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Entity\Trade;
use App\Domain\Trader\Service\TradeDeleter;
use App\Infrastructure\Doctrine\BulkPersister;
use App\Infrastructure\Fetcher\FetcherInterface;
use Generator;
final class Importer implements IterableImporterInterface
{
    use CountAwareTrait;

    public function __construct(
        private readonly FetcherInterface $fetcher,
        private readonly TradeBuilder $tradeBuilder,
        private readonly TradeDeleter $tradeDeleter,
        private readonly BulkPersister $bulkPersister,
    ) {
    }

    /**
     * @param Options $options
     *
     * @throws EntityNotFoundException
     */
    public function import(ImportOptionsInterface $options): Generator
    {
        $response = $this->fetchDataFromApi($options);
        $this->count = count($response->trades);

        $this->tradeDeleter->deleteAllByYearAndTraderMoexIdAndMarketType(
            year: $options->year,
            traderMoexId: $options->traderMoexId,
            marketType: $options->marketType
        );

        foreach ($response->trades as $dto) {
            $trade = $this->tradeBuilder->create($dto);
            $this->bulkPersister->persist($trade);

            yield;
        }

        $this->bulkPersister->flushAndClear(Trade::class);
    }

    /**
     * @param Options $options
     */
    private function fetchDataFromApi(ImportOptionsInterface $options): Response
    {
        /** @var Response $response */
        $response = $this->fetcher->fetch(
            new Request(
                year: $options->year,
                traderMoexId: $options->traderMoexId,
                marketType: $options->marketType
            )
        );

        return $response;
    }
}

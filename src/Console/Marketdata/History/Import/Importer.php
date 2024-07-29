<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import;

use App\Common\Importer\ImporterInterface;
use App\Common\Importer\ImportOptionsInterface;
use App\Console\Marketdata\History\Import\Builder\CandleBuilder;
use App\Console\Marketdata\History\Import\Fetcher\Request;
use App\Console\Marketdata\History\Import\Fetcher\Response;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Marketdata\Entity\Candle;
use App\Domain\Marketdata\Service\CandleDeleter;
use App\Infrastructure\Doctrine\BulkPersister;
use App\Infrastructure\Fetcher\FetcherInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

final class Importer implements ImporterInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly FetcherInterface $fetcher,
        private readonly CandleBuilder $candleBuilder,
        private readonly CandleDeleter $candleDeleter,
        private readonly BulkPersister $bulkPersister,
    ) {
    }

    /**
     * @param Options $options
     *
     * @throws EntityNotFoundException
     */
    public function import(ImportOptionsInterface $options): void
    {
        /** @var Response $response */
        $response = $this->fetcher->fetch(
            new Request($options->figi, $options->year)
        );

        $progressBar = $options->progressBar ?? null;
        $progressBar?->setMaxSteps(count($response->candles));

        $this->candleDeleter->deleteAllByShareFigiAndYear($options->figi, $options->year);

        foreach ($response->candles as $dto) {
            $candle = $this->candleBuilder->create($dto);
            $this->bulkPersister->persist($candle);

            $progressBar?->advance();
        }

        $this->bulkPersister->flushAndClear(Candle::class);
    }

}

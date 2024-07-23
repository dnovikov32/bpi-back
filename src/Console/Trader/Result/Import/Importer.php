<?php

declare(strict_types=1);

namespace App\Console\Trader\Result\Import;

use App\Common\Importer\ImporterInterface;
use App\Common\Importer\ImportOptionsInterface;
use App\Console\Trader\Result\Import\Builder\AggregateResultBuilder;
use App\Console\Trader\Result\Import\Fetcher\Request;
use App\Console\Trader\Result\Import\Fetcher\Response;
use App\Domain\Trader\Repository\ResultRepositoryInterface;
use App\Infrastructure\Fetcher\FetcherInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

final class Importer implements ImporterInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly FetcherInterface $fetcher,
        private readonly AggregateResultBuilder $aggregateResultBuilder,
        private readonly ResultRepositoryInterface $resultRepository,
    ) {
    }

    /**
     * @param Options $options
     */
    public function import(ImportOptionsInterface $options): void
    {
        /** @var Response $response */
        $response = $this->fetcher->fetch(
            new Request($options->year)
        );

        $progressBar = $options->progressBar ?? null;
        $progressBar?->setMaxSteps(count($response->results));

        foreach ($response->results as $dto) {
            $result = $this->aggregateResultBuilder->updateOrCreate($dto);
            $this->resultRepository->save($result);

            $progressBar?->advance();
        }
    }
}

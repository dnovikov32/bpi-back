<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import;

use App\Common\Importer\ImporterInterface;
use App\Common\Importer\ImportOptionsInterface;
use App\Console\Trader\Trader\Import\Fetcher\Request;
use App\Console\Trader\Trader\Import\Fetcher\Response;
use App\Domain\Trader\Repository\TraderRepositoryInterface;
use App\Domain\Trader\Service\TraderBuilder;
use App\Infrastructure\Fetcher\FetcherInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

final class Importer implements ImporterInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly FetcherInterface $fetcher,
        private readonly TraderBuilder $traderBuilder,
        private readonly TraderRepositoryInterface $traderRepository,
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
        $progressBar?->setMaxSteps(count($response->traders));

        foreach ($response->traders as $dto) {
            $trader = $this->traderBuilder->updateOrCreate($dto->year, $dto->id,  $dto->name);
            $this->traderRepository->save($trader);

            $progressBar?->advance();
        }
    }
}

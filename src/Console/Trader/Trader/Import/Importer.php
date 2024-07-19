<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import;

use App\Common\Importer\ImporterInterface;
use App\Common\Importer\ImportOptionsInterface;
use App\Console\Trader\Trader\Import\Fetcher\Request;
use App\Console\Trader\Trader\Import\Fetcher\Response;
use App\Console\Trader\Trader\Import\Fetcher\Trader as TraderDto;
use App\Domain\Trader\Factory\TraderFactory;
use App\Domain\Trader\Model\Trader;
use App\Domain\Trader\Service\TraderSaver;
use App\Infrastructure\Fetcher\FetcherInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

final class Importer implements ImporterInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly FetcherInterface $fetcher,
        private readonly TraderFactory $traderFactory,
        private readonly TraderSaver $traderSaver,
    ) {
    }

    /**
     * @param Options $options
     */
    public function import(ImportOptionsInterface $options): void
    {
        /** @var Response $response */
        $response = $this->fetcher->fetch(
            new Request(
                year: $options->getYear(),
                fileName: $options->getFileName()
            )
        );

        $progressBar = $options->getProgressBar();
        $progressBar?->setMaxSteps(count($response->traders));

        foreach ($response->traders as $traderDto) {
            $this->traderSaver->updateOrCreate($this->createTrader($traderDto));
            $progressBar?->advance();
        }
    }

    private function createTrader(TraderDto $traderDto): Trader
    {
        return $this->traderFactory->create(
            moexId: $traderDto->id,
            name: $traderDto->name,
            year: $traderDto->year,
        );
    }

}

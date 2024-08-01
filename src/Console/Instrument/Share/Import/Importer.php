<?php

declare(strict_types=1);

namespace App\Console\Instrument\Share\Import;

use App\Common\Importer\CountAwareTrait;
use App\Common\Importer\ImportOptionsInterface;
use App\Common\Importer\IterableImporterInterface;
use App\Domain\Instrument\Builder\ShareBuilder;
use App\Domain\Instrument\Dto\ShareDto;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;
use DateTimeImmutable;
use Exception;
use Generator;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\Share as TinkoffShare;
use Tinkoff\Invest\V1\SharesResponse;
use Traversable;

final class Importer implements IterableImporterInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;
    use CountAwareTrait;

    public function __construct(
        private readonly TinkoffClientsFactory $tinkoffClientsFactory,
        private readonly ShareBuilder $shareBuilder,
        private readonly ShareRepositoryInterface $shareRepository,
    ) {
    }

    /**
     * @param Options $options
     *
     * @throws Exception
     */
    public function import(ImportOptionsInterface $options): Generator
    {
        /** @var TinkoffShare[] $instruments */
        $instruments = $this->fetchSharesDataFromApi($options);
        $this->count = count($instruments);

        foreach ($instruments as $instrument) {
            $share = $this->shareBuilder->updateOrCreate($this->createShareDto($instrument));
            $this->shareRepository->save($share);

            yield;
        }
    }

    /**
     * @throws Exception
     */
    private function fetchSharesDataFromApi(Options $options): Traversable
    {
        $request = (new InstrumentsRequest())
            ->setInstrumentStatus($options->instrumentStatus);

        /** @var SharesResponse $response */
        list($response, $status) = $this->tinkoffClientsFactory
            ->getInstrumentsServiceClient()
            ->Shares($request)
            ->wait();

        return $response->getInstruments();
    }

    private function createShareDto(TinkoffShare $instrument): ShareDto
    {
        return new ShareDto(
            figi: $instrument->getFigi(),
            ticker: $instrument->getTicker(),
            isin: $instrument->getIsin(),
            lot: $instrument->getLot(),
            currency: $instrument->getCurrency(),
            name: $instrument->getName(),
            uid: $instrument->getUid(),
            first1minCandleDate: $this->transformToDatetime((string) $instrument->getFirst1MinCandleDate()?->getSeconds()),
            first1dayCandleDate: $this->transformToDatetime((string) $instrument->getFirst1dayCandleDate()?->getSeconds()),
        );
    }

    private function transformToDatetime(?string $timestamp): ?DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('U', $timestamp) ?: null;
    }
}

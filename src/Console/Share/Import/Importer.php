<?php

declare(strict_types=1);

namespace App\Console\Share\Import;

use App\Common\Importer\ImporterInterface;
use App\Common\Importer\ImportOptionsInterface;
use App\Domain\Instrument\Model\Share;
use App\Domain\Instrument\Service\ShareSaver;
use DateTimeImmutable;
use Exception;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\SharesResponse;
use Tinkoff\Invest\V1\Share as TinkoffShare;
use Traversable;

final class Importer implements ImporterInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly TinkoffClientsFactory $tinkoffClientsFactory,
        private readonly ShareSaver $shareSaver,
    ) {
    }

    /**
     * @throws Exception
     */
    public function import(ImportOptionsInterface $options): void
    {
        /** @var TinkoffShare[] $instruments */
        $instruments = $this->fetchSharesData();

        foreach ($instruments as $instrument) {
            $this->shareSaver->create(
                $this->createShare($instrument)
            );
        }
    }

    /**
     * @return Traversable<TinkoffShare>
     *
     * @throws Exception
     */
    private function fetchSharesData(): Traversable
    {
        $request = new InstrumentsRequest();

        /** @var SharesResponse $response */
        list($response, $status) = $this->tinkoffClientsFactory
            ->getInstrumentsServiceClient()
            ->Shares($request)
            ->wait();

        return $response->getInstruments()->getIterator();
    }

    private function createShare(TinkoffShare $instrument): Share
    {
        return new Share(
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

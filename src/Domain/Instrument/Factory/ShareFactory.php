<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Factory;

use App\Domain\Common\Service\IdService;
use App\Domain\Instrument\Model\Share;
use DateTimeImmutable;

final class ShareFactory
{
    public function __construct(
        private readonly IdService $idService
    ) {
    }

    public function create(
        string $figi,
        string $ticker,
        string $isin,
        int $lot,
        string $currency,
        string $name,
        string $uid,
        ?DateTimeImmutable $first1minCandleDate,
        ?DateTimeImmutable $first1dayCandleDate,
    ): Share
    {
        return new Share(
            id: $this->idService->generate(),
            figi: $figi,
            ticker: $ticker,
            isin: $isin,
            lot: $lot,
            currency: $currency,
            name: $name,
            uid: $uid,
            first1minCandleDate: $first1minCandleDate,
            first1dayCandleDate: $first1dayCandleDate,
        );
    }
}

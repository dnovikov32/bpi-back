<?php

declare(strict_types=1);

namespace App\Domain\Instrument\Factory;

use App\Domain\Common\Service\IdService;
use App\Domain\Instrument\Dto\ShareDto;
use App\Domain\Instrument\Entity\Share;

final class ShareFactory
{
    public function __construct(
        private readonly IdService $idService
    ) {
    }

    public function create(ShareDto $dto): Share
    {
        return new Share(
            id: $this->idService->generate(),
            figi: $dto->figi,
            ticker: $dto->ticker,
            isin: $dto->isin,
            uid: $dto->uid,
            classCode: $dto->classCode,
            lot: $dto->lot,
            currency: $dto->currency,
            name: $dto->name,
            first1minCandleDate: $dto->first1minCandleDate,
            first1dayCandleDate: $dto->first1dayCandleDate,
        );
    }
}

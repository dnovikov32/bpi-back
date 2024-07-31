<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import\Builder;

use App\Console\Marketdata\History\Import\Dto\ImportCandleDto;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;
use App\Domain\Marketdata\Entity\Candle;
use App\Domain\Marketdata\Factory\CandleFactory;
use DateTimeImmutable;
use DateTimeInterface;

final class CandleBuilder
{
    public function __construct(
        private readonly ShareRepositoryInterface $shareRepository,
        private readonly CandleFactory $candleFactory,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function create(ImportCandleDto $dto): Candle
    {
        $share = $this->shareRepository->findByUid($dto->instrumentUid);

        return $this->candleFactory->create(
            share: $share,
            dateTime: $this->transformStringToDatetime($dto->dateTime),
            open: $dto->open,
            close: $dto->close,
            high: $dto->high,
            low: $dto->low,
            volume: $dto->volume,
        );
    }

    /**
     * TODO: move data transform back to Console/Marketdata/History/Import/Fetcher/ResponseTransformer.php (memory problem)
     */
    private function transformStringToDatetime(string $dateTime): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $dateTime);
    }
}

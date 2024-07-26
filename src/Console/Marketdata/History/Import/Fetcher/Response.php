<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import\Fetcher;

use App\Console\Marketdata\History\Import\Dto\ImportCandleDto;
use App\Infrastructure\Fetcher\Response\ResponseInterface;

class Response implements ResponseInterface
{
    /**
     * @param ImportCandleDto[] $candles
     */
    public function __construct(
        public readonly array $candles
    ) {
    }
}

<?php

declare(strict_types=1);

namespace App\Console\Trader\Trade\Import\Fetcher;

use App\Console\Trader\Trade\Import\Dto\ImportTradeDto;
use App\Infrastructure\Fetcher\Response\ResponseInterface;

class Response implements ResponseInterface
{
    /**
     * @param ImportTradeDto[] $trades
     */
    public function __construct(
        public readonly array $trades
    ) {
    }
}

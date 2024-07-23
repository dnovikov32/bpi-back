<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import\Fetcher;

use App\Console\Trader\Trader\Import\Dto\ImportTraderDto;
use App\Infrastructure\Fetcher\Response\ResponseInterface;

class Response implements ResponseInterface
{
    /**
     * @param ImportTraderDto[] $traders
     */
    public function __construct(
        public readonly array $traders
    ) {
    }
}

<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import\Fetcher;

use App\Infrastructure\Fetcher\Response\ResponseInterface;

class Response implements ResponseInterface
{
    /**
     * @param Trader[] $traders
     */
    public function __construct(
        public readonly array $traders
    ) {
    }
}

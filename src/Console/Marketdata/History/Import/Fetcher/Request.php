<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import\Fetcher;

use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;

final class Request implements ApiRequestInterface
{
    public function __construct(
        public readonly string $figi,
        public readonly int $year,
    ) {
    }
}

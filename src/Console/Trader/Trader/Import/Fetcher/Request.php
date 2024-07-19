<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import\Fetcher;

use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;

final class Request implements ApiRequestInterface
{
    public function __construct(
        public readonly string $year,
        public readonly string $fileName,
    ) {
    }
}

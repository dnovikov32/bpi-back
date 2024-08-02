<?php

declare(strict_types=1);

namespace App\Console\Trader\Trade\Import\Fetcher;

use App\Domain\Trader\Enum\MarketType;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;

final class Request implements ApiRequestInterface
{
    public function __construct(
        public readonly int $year,
        public readonly int $traderMoexId,
        public readonly MarketType $marketType,
    ) {
    }
}

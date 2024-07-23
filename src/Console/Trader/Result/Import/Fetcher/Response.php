<?php

declare(strict_types=1);

namespace App\Console\Trader\Result\Import\Fetcher;

use App\Console\Trader\Result\Import\Dto\ImportResultDto;
use App\Infrastructure\Fetcher\Response\ResponseInterface;

class Response implements ResponseInterface
{
    /**
     * @param ImportResultDto[] $results
     */
    public function __construct(
        public readonly array $results
    ) {
    }
}

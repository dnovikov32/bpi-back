<?php

declare(strict_types=1);

namespace App\Console\Trader\Result\Import\Fetcher;

use App\Infrastructure\Fetcher\Request\BaseRequestBuilder;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;

final class RequestBuilder extends BaseRequestBuilder
{
    /**
     * @param Request $request
     */
    public function getUrl(ApiRequestInterface $request): string
    {
        return str_replace(':year', (string) $request->year, parent::getUrl($request));
    }
}

<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import\Fetcher;

use App\Infrastructure\Fetcher\Request\BaseRequestBuilder;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;

final class RequestBuilder extends BaseRequestBuilder
{
    /**
     * @param Request $request
     */
    public function getUrl(ApiRequestInterface $request): string
    {
        return sprintf(
            '%s/%s/%s',
            parent::getUrl($request),
            $request->year,
            $request->fileName,
        );
    }
}

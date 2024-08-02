<?php

declare(strict_types=1);

namespace App\Console\Trader\Trade\Import\Fetcher;

use App\Infrastructure\Fetcher\Request\BaseRequestBuilder;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;

final class RequestBuilder extends BaseRequestBuilder
{
    /**
     * @param Request $request
     */
    public function getUrl(ApiRequestInterface $request): string
    {
        $url = str_replace(':year', (string) $request->year, parent::getUrl($request));
        $fileName = sprintf('%s_%s.zip', $request->marketType->value(), $request->traderMoexId);

        return sprintf('%s/%s', $url, $fileName);
    }
}

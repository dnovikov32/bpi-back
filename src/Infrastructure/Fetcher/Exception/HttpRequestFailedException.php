<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class HttpRequestFailedException extends BadRequestHttpException
{
}

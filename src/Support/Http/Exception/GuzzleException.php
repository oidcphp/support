<?php

declare(strict_types=1);

namespace OpenIDConnect\Support\Http\Exception;

use Psr\Http\Client\ClientExceptionInterface;
use RuntimeException;

/**
 * Class GuzzleException.
 */
class GuzzleException extends RuntimeException implements ClientExceptionInterface
{
}

<?php

declare(strict_types=1);

namespace OpenIDConnect\Support\Http\Exception;

use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * Class NetworkException.
 */
class NetworkException extends \RuntimeException implements NetworkExceptionInterface
{
    use RequestAwaitTrait;

    /**
     * NetworkException constructor.
     *
     * @param RequestInterface $request
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(RequestInterface $request, string $message = '', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);

        $this->request = $request;
    }
}

<?php

declare(strict_types=1);

namespace OpenIDConnect\Support\Http\Exception;

use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Throwable;

class RequestException extends \RuntimeException implements RequestExceptionInterface
{
    use RequestAwaitTrait;

    /**
     * RequestException constructor.
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

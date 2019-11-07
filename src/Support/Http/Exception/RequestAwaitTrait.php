<?php declare(strict_types=1);

namespace OpenIDConnect\Support\Http\Exception;

use Psr\Http\Message\RequestInterface;

trait RequestAwaitTrait
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * {@inheritdoc}
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}

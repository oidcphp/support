<?php declare(strict_types=1);

namespace OpenIDConnect\Support\Container;

use Psr\Container\ContainerInterface;

/**
 * Minimal implementation for ContainerInterface
 *
 * @link https://www.php-fig.org/psr/psr-11/
 */
class Container implements ContainerInterface
{
    /**
     * @var array
     */
    private $instance;

    /**
     * @param array $instance
     */
    public function __construct(array $instance = [])
    {
        $this->instance = $instance;
    }

    /**
     * @inheritDoc
     */
    public function get($identifier)
    {
        if ($this->has($identifier)) {
            return $this->instance[$identifier];
        }

        throw new EntryNotFoundException("The entry '{$identifier}' is not found");
    }

    /**
     * @inheritDoc
     */
    public function has($identifier)
    {
        return isset($this->instance[$identifier]);
    }

    /**
     * Inject instance
     *
     * @param string $identifier
     * @param mixed $instance
     */
    public function set(string $identifier, $instance): void
    {
        $this->instance[$identifier] = $instance;
    }
}

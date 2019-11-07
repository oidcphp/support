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
    public function get($id)
    {
        if ($this->has($id)) {
            return $this->instance[$id];
        }

        throw new EntryNotFoundException("The entry '{$id}' is not found");
    }

    /**
     * @inheritDoc
     */
    public function has($id)
    {
        return isset($this->instance[$id]);
    }

    /**
     * Inject instance
     *
     * @param string $id
     * @param mixed $instance
     */
    public function set(string $id, $instance): void
    {
        $this->instance[$id] = $instance;
    }
}

<?php declare(strict_types=1);

namespace Tests\Support\Container;

use OpenIDConnect\Support\Container\Container;
use PHPUnit\Framework\TestCase;
use Psr\Container\NotFoundExceptionInterface;

class ContainerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSetAndGetTheEntry(): void
    {
        $target = new Container();

        $target->set('some-entry', 'some-instance');

        $this->assertSame('some-instance', $target->get('some-entry'));
    }

    /**
     * @test
     */
    public function shouldGetEntryWithPrepareEntry(): void
    {
        $target = new Container([
            'some-entry' => 'some-instance',
        ]);

        $this->assertSame('some-instance', $target->get('some-entry'));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenEntryNotFound(): void
    {
        $this->expectException(NotFoundExceptionInterface::class);

        $target = new Container();

        $target->get('not-found-entry');
    }
}

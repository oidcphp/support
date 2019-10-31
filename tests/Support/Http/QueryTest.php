<?php

declare(strict_types=1);

namespace Tests\Support\Http;

use OpenIDConnect\Support\Http\Query;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    public function encodeCase()
    {
        return [
            [[], ''],
            [['a' => '+1'], 'a=%2B1'],
        ];
    }

    /**
     * @test
     * @dataProvider encodeCase
     */
    public function shouldReturnEmptyStringWhenCallBuild($decoded, $encoded): void
    {
        $this->assertSame($encoded, Query::build($decoded));
    }

    /**
     * @test
     * @dataProvider encodeCase
     */
    public function shouldReturnEmptyArrayWhenCallBuild2($decoded, $encoded): void
    {
        $this->assertSame($decoded, Query::parse($encoded));
    }
}

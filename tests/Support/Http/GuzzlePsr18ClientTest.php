<?php

declare(strict_types=1);

namespace Tests\Support\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use OpenIDConnect\Support\Http\Exception\NetworkException;
use OpenIDConnect\Support\Http\Exception\RequestException;
use OpenIDConnect\Support\Http\GuzzlePsr18Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\NetworkExceptionInterface;

class GuzzlePsr18ClientTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnResponseWhenOkay(): void
    {
        $client = new Client([
            'handler' => HandlerStack::create(new MockHandler([new Response(200, [], 'excepted')])),
        ]);

        $target = new GuzzlePsr18Client($client);

        $actual = $target->sendRequest(new Request('GET', 'whatever'));

        $this->assertSame('excepted', (string)$actual->getBody());
        $this->assertSame(200, $actual->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldReturnBadResponseWhen500WithResponse(): void
    {
        $client = new Client([
            'handler' => HandlerStack::create(new MockHandler([new Response(500, [], 'excepted')])),
        ]);

        $target = new GuzzlePsr18Client($client);

        $actual = $target->sendRequest(new Request('GET', 'whatever'));

        $this->assertSame('excepted', (string)$actual->getBody());
        $this->assertSame(500, $actual->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldReturnBadResponseWhen500WithoutResponse(): void
    {
        $this->expectException(RequestException::class);

        $client = new Client([
            'handler' => HandlerStack::create(new MockHandler([
                new BadResponseException('excepted', new Request('GET', 'whatever')),
            ])),
        ]);

        $target = new GuzzlePsr18Client($client);

        $actual = $target->sendRequest(new Request('GET', 'whatever'));

        $this->assertSame('excepted', (string)$actual->getBody());
        $this->assertSame(500, $actual->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldReturnBadResponseWhen400(): void
    {
        $this->expectException(ClientExceptionInterface::class);

        $client = new Client([
            'handler' => HandlerStack::create(new MockHandler([new TransferException('something')])),
        ]);

        $target = new GuzzlePsr18Client($client);

        $target->sendRequest(new Request('GET', 'whatever'));
    }

    /**
     * @test
     */
    public function shouldReturnBadResponseWhenNetworkException(): void
    {
        $this->expectException(ClientExceptionInterface::class);

        $client = new Client([
            'handler' => HandlerStack::create(new MockHandler([
                new ConnectException('whatever', new Request('GET', 'mock')),
            ])),
        ]);

        $target = new GuzzlePsr18Client($client);

        $target->sendRequest(new Request('GET', 'whatever'));
    }

    /**
     * @test
     */
    public function shouldGetMockRequestInException(): void
    {
        $client = new Client([
            'handler' => HandlerStack::create(new MockHandler([
                new ConnectException('whatever', new Request('GET', 'mock')),
            ])),
        ]);

        $target = new GuzzlePsr18Client($client);

        try {
            $target->sendRequest(new Request('GET', 'whatever'));
        } catch (NetworkExceptionInterface $e) {
            $this->assertSame('mock', (string)$e->getRequest()->getUri());
        }
    }
}

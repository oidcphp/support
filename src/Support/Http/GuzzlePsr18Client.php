<?php

declare(strict_types=1);

namespace OpenIDConnect\Support\Http;

use Exception;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use OpenIDConnect\Support\Http\Exception\ClientException;
use OpenIDConnect\Support\Http\Exception\NetworkException;
use OpenIDConnect\Support\Http\Exception\RequestException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzlePsr18Client implements ClientInterface
{
    /**
     * @var GuzzleClientInterface
     */
    private $guzzleClient;

    /**
     * @param GuzzleClientInterface $guzzleClient
     */
    public function __construct(GuzzleClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @inheritDoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->guzzleClient->send($request);
        } catch (ConnectException $e) {
            throw new NetworkException($e->getRequest(), 'Could not connect to ' . $request->getUri(), $e);
        } catch (GuzzleRequestException $e) {
            $response = $e->getResponse();

            if (null !== $response) {
                return $response;
            }

            throw new RequestException($e->getRequest(), 'No response returned from ' . $request->getUri(), $e);
        } catch (Exception $e) {
            throw new ClientException('Something went wrong while send request to ' . $request->getUri(), 0, $e);
        }
    }
}

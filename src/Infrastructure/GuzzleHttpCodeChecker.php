<?php


namespace StatusChecker\Infrastructure;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use StatusChecker\Domain\HttpCodeChecker;
use StatusChecker\Exception\HttpCodeCheckFailed;

/**
 * Class GuzzleHttpCodeChecker
 * @package StatusChecker\Infrastructure
 */
class GuzzleHttpCodeChecker implements HttpCodeChecker
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * GuzzleHttpCodeChecker constructor.
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                'http_errors' => false
            ]
        );
    }

    /**
     * @param string $url
     * @return int
     */
    public function checkHttpCodeForUrl(string $url): int
    {
        try {
            $response = $this->client->head($url);

            return $response->getStatusCode();
        } catch (RequestException $exception) {
            throw HttpCodeCheckFailed::fromHttpRequest($exception->getRequest());
        } catch (GuzzleException $exception) {
            throw HttpCodeCheckFailed::fromGuzzleException($exception);
        }
    }
}
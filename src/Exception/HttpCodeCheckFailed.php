<?php

namespace StatusChecker\Exception;


use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;

/**
 * Class HttpCodeCheckFailed
 * @package StatusChecker\Exception
 */
class HttpCodeCheckFailed extends \RuntimeException implements StatusCheckerException
{

    /**
     * @param RequestInterface|null $request
     * @param int $code
     * @param \Throwable|null $previous
     * @return static
     */
    public static function fromHttpRequest(RequestInterface $request = null, $code = 0, \Throwable $previous = null)
    {
        return new static(
            'Request failed!' . (isset($request) ? ' Method ' . $request->getMethod() . ' to ' . $request->getUri() : ''),
            $code, $previous
        );
    }

    /**
     * @param GuzzleException|null $exception
     * @param int $code
     * @param \Throwable|null $previous
     * @return static
     */
    public static function fromGuzzleException(
        GuzzleException $exception = null,
        $code = 0,
        \Throwable $previous = null
    ) {
        return new static(
            'Request failed!' . (isset($exception) ? ' Message: ' . $exception->getMessage() : ''), $code, $previous
        );
    }
}
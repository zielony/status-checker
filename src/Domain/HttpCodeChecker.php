<?php


namespace StatusChecker\Domain;


use StatusChecker\Exception\HttpCodeCheckFailed;

/**
 * Interface HttpCodeChecker
 * @package StatusChecker\Domain
 */
interface HttpCodeChecker
{
    /**
     * @param string $url
     * @return int
     *
     * @throws HttpCodeCheckFailed
     */
    public function checkHttpCodeForUrl(string $url): int;
}
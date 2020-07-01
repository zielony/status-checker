<?php

namespace StatusChecker\Exception;


use StatusChecker\Domain\EndpointStatus;

/**
 * Class EntityNotFound
 * @package StatusChecker\Exception
 */
class EntityNotFound extends \UnexpectedValueException implements StatusCheckerException
{
    /**
     * @param int $id
     * @param int $code
     * @param \Throwable|null $previous
     * @return static
     */
    public static function fromEndpointId(int $id, $code = 0, \Throwable $previous = null)
    {
        return new static(
            'Could not found endpoint with ID=' . $id . '!', $code, $previous
        );
    }

    /**
     * @param EndpointStatus $status
     * @param int $code
     * @param \Throwable|null $previous
     * @return static
     */
    public static function fromEndpointStatus(EndpointStatus $status, $code = 0, \Throwable $previous = null)
    {
        return new static(
            'Could not found endpoint with status of ' . $status->getValue() . '!', $code, $previous
        );
    }
}
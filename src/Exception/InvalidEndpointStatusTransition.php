<?php

namespace StatusChecker\Exception;


use StatusChecker\Domain\EndpointStatus;

/**
 * Class InvalidEndpointStatusTransition
 * @package StatusChecker\Exception
 */
class InvalidEndpointStatusTransition extends \UnexpectedValueException implements StatusCheckerException
{

    /**
     * @param EndpointStatus $currentStatus
     * @param EndpointStatus $newStatus
     * @param int $code
     * @param \Throwable|null $previous
     * @return static
     */
    public static function fromEndpointStatuses(
        EndpointStatus $currentStatus,
        EndpointStatus $newStatus,
        $code = 0,
        \Throwable $previous = null
    ) {
        return new static(
            'Endpoint can not transition from ' . $currentStatus->getValue() . ' state to ' . $newStatus->getValue(),
            $code,
            $previous
        );
    }
}
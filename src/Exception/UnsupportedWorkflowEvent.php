<?php

namespace StatusChecker\Exception;


use Prooph\Common\Messaging\DomainEvent;

/**
 * Class UnsupportedWorkflowEvent
 * @package StatusChecker\Exception
 */
class UnsupportedWorkflowEvent extends \UnexpectedValueException implements StatusCheckerException
{

    /**
     * @param DomainEvent $event
     * @param int $code
     * @param \Throwable|null $previous
     * @return static
     */
    public static function fromDomainEvent(DomainEvent $event, $code = 0, \Throwable $previous = null)
    {
        return new static(
            'Unrecognized event received in workflow: ' . get_class($event), $code, $previous
        );
    }
}
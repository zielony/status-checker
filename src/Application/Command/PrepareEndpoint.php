<?php

namespace StatusChecker\Application\Command;


use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;
use StatusChecker\Domain\EndpointStatus;

/**
 * Class PrepareEndpoint
 * @package StatusChecker\Application\Command
 */
class PrepareEndpoint extends Command
{
    use PayloadTrait;

    /**
     * PrepareEndpoint constructor.
     * @param EndpointStatus|null $status
     */
    public function __construct(?EndpointStatus $status = null)
    {
        $this->init();
        $this->setPayload(
            [
                'status' => (is_null($status) ? EndpointStatus::NEW() : $status)
            ]
        );
    }

    /**
     * @return EndpointStatus
     */
    public function getStatus(): EndpointStatus
    {
        return new EndpointStatus($this->payload['status']);
    }
}
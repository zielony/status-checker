<?php


namespace StatusChecker\Domain\Event;


use Prooph\Common\Messaging\DomainEvent;
use Prooph\Common\Messaging\PayloadTrait;

/**
 * Class EndpointSkipped
 * @package StatusChecker\Domain\Event
 */
class EndpointSkipped extends DomainEvent
{
    use PayloadTrait;

    /**
     * PrepareEndpoint constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->init();
        $this->setPayload(
            [
                'id' => $id
            ]
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->payload['id'];
    }
}
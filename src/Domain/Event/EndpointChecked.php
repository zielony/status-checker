<?php


namespace StatusChecker\Domain\Event;


use Prooph\Common\Messaging\DomainEvent;
use Prooph\Common\Messaging\PayloadTrait;

/**
 * Class EndpointChecked
 * @package StatusChecker\Domain\Event
 */
abstract class EndpointChecked extends DomainEvent
{
    use PayloadTrait;

    /**
     * MarkEndpointAsReachableHandler constructor.
     * @param int $id
     * @param int|null $httpCode
     */
    public function __construct(int $id, ?int $httpCode)
    {
        $this->init();
        $this->setPayload(
            [
                'id' => $id,
                'httpCode' => $httpCode
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

    /**
     * @return int|null
     */
    public function getHttpCode(): ?int
    {
        return $this->payload['httpCode'];
    }
}
<?php


namespace StatusChecker\Domain\Event;


use Prooph\Common\Messaging\DomainEvent;
use Prooph\Common\Messaging\PayloadTrait;

/**
 * Class EndpointPrepared
 * @package StatusChecker\Domain\Event
 */
class EndpointPrepared extends DomainEvent
{
    use PayloadTrait;

    /**
     * PrepareEndpoint constructor.
     * @param int $id
     * @param string $url
     */
    public function __construct(int $id, string $url)
    {
        $this->init();
        $this->setPayload(
            [
                'id' => $id,
                'url' => $url
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
     * @return string
     */
    public function getUrl(): string
    {
        return $this->payload['url'];
    }
}
<?php


namespace StatusChecker\Application\Command;


use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

/**
 * Class MarkEndpointAsChecked
 * @package StatusChecker\Application\Command
 */
abstract class MarkEndpointAsChecked extends Command
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
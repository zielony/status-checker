<?php

namespace StatusChecker\Application\Command;


use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

/**
 * Class MarkEndpointAsFailed
 * @package StatusChecker\Application\Command
 */
class MarkEndpointAsFailed extends Command
{
    use PayloadTrait;

    /**
     * MarkEndpointAsFailed constructor.
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
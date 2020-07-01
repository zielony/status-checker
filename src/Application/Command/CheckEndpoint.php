<?php

namespace StatusChecker\Application\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

/**
 * Class CheckEndpoint
 * @package StatusChecker\Application\Command
 */
class CheckEndpoint extends Command
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
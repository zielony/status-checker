<?php

namespace StatusChecker\Domain;


use StatusChecker\Exception\InvalidEndpointStatusTransition;

/**
 * Class Endpoint
 * @package StatusChecker\Domain
 */
class Endpoint
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var EndpointStatus
     */
    protected $status;

    /**
     * @var int|null
     */
    protected $httpCode;

    /**
     * Endpoint constructor.
     * @param int $id
     * @param string $url
     * @param EndpointStatus $status
     * @param int|null $httpCode
     */
    public function __construct(int $id, string $url, EndpointStatus $status, ?int $httpCode = null)
    {
        $this->id = $id;
        $this->url = $url;
        $this->status = $status;
        $this->httpCode = $httpCode;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return EndpointStatus
     */
    public function getStatus(): EndpointStatus
    {
        return $this->status;
    }

    /**
     * @param EndpointStatus $status
     */
    protected function setStatus(EndpointStatus $status): void
    {
        switch ($status) {
            case EndpointStatus::NEW():
                throw InvalidEndpointStatusTransition::fromEndpointStatuses($this->status, $status);
                break;

            case EndpointStatus::PROCESSING():
                if ($this->status != EndpointStatus::NEW()) {
                    throw InvalidEndpointStatusTransition::fromEndpointStatuses($this->status, $status);
                }
                break;

            case EndpointStatus::DONE():
            case EndpointStatus::ERROR():
                if ($this->status != EndpointStatus::PROCESSING()) {
                    throw InvalidEndpointStatusTransition::fromEndpointStatuses($this->status, $status);
                }
                break;
        }

        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getHttpCode(): ?int
    {
        return $this->httpCode;
    }

    /**
     * Changes endpoint status to "done" and sets given HTTP code
     *
     * @param int|null $httpCode
     */
    public function markReachable(?int $httpCode): void
    {
        $this->setStatus(EndpointStatus::DONE());
        $this->httpCode = $httpCode;
    }

    /**
     * Changes endpoint status to "done" and sets given HTTP code
     * (in case it's different from markReachable() in the future)
     *
     * @param int|null $httpCode
     */
    public function markUnreachable(?int $httpCode): void
    {
        $this->setStatus(EndpointStatus::DONE());
        $this->httpCode = $httpCode;
    }

    /**
     * Changes endpoint status to "error"
     */
    public function markFailed(): void
    {
        $this->setStatus(EndpointStatus::ERROR());
    }

    /**
     * Changes endpoint status to "processing" so another process does not pick it up
     */
    public function prepare(): void
    {
        $this->setStatus(EndpointStatus::PROCESSING());
    }
}
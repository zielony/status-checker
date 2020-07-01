<?php

namespace StatusChecker\Infrastructure\Repository;


use StatusChecker\Domain\Endpoint;
use StatusChecker\Domain\Endpoints;
use StatusChecker\Domain\EndpointStatus;
use StatusChecker\Exception\EntityNotFound;

/**
 * Class EndpointsInMemory
 * @package StatusChecker\Infrastructure\Repository
 */
class EndpointsInMemory implements Endpoints
{
    /**
     * @var Endpoint[]
     */
    protected $endpoints = [];

    /**
     * @param int $id
     * @return Endpoint
     */
    public function loadById(int $id): Endpoint
    {
        if (array_key_exists($id, $this->endpoints)) {
            return $this->endpoints[$id];
        }

        throw EntityNotFound::fromEndpointId($id);
    }

    /**
     * @param EndpointStatus $status
     * @return Endpoint
     */
    public function loadByStatus(EndpointStatus $status): Endpoint
    {
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->getStatus() == $status) {
                return $endpoint;
            }
        }

        throw EntityNotFound::fromEndpointStatus($status);
    }

    /**
     * @param Endpoint $endpoint
     */
    public function save(Endpoint $endpoint): void
    {
        $this->endpoints[$endpoint->getId()] = $endpoint;
    }
}
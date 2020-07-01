<?php


namespace StatusChecker\Domain;

/**
 * Interface Endpoints
 * @package StatusChecker\Domain
 */
interface Endpoints
{
    /**
     * @param int $id
     * @return Endpoint
     */
    public function loadById(int $id): Endpoint;

    /**
     * @param EndpointStatus $status
     * @return Endpoint
     */
    public function loadByStatus(EndpointStatus $status): Endpoint;

    /**
     * @param Endpoint $endpoint
     */
    public function save(Endpoint $endpoint): void;
}
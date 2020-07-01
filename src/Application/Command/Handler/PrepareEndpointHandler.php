<?php

namespace StatusChecker\Application\Command\Handler;


use StatusChecker\Application\Command\PrepareEndpoint;
use StatusChecker\Application\EventBus;
use StatusChecker\Domain\Endpoints;
use StatusChecker\Domain\Event\EndpointPrepared;

/**
 * Class PrepareEndpointHandler
 * @package StatusChecker\Application\Command\Handler
 */
class PrepareEndpointHandler
{
    /**
     * @var Endpoints
     */
    private $endpoints;

    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * PrepareEndpointHandler constructor.
     * @param Endpoints $endpoints
     * @param EventBus $eventBus
     */
    public function __construct(Endpoints $endpoints, EventBus $eventBus)
    {
        $this->endpoints = $endpoints;
        $this->eventBus = $eventBus;
    }

    /**
     * @param PrepareEndpoint $command
     */
    public function __invoke(PrepareEndpoint $command)
    {
        $endpoint = $this->endpoints->loadByStatus($command->getStatus());
        $endpoint->prepare();
        $this->endpoints->save($endpoint);

        $this->eventBus->dispatch(
            new EndpointPrepared($endpoint->getId(), $endpoint->getUrl())
        );
    }

}
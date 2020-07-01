<?php


namespace StatusChecker\Application\Command\Handler;


use StatusChecker\Application\Command\MarkEndpointAsReachable;
use StatusChecker\Application\EventBus;
use StatusChecker\Domain\Endpoints;
use StatusChecker\Domain\EndpointStatus;
use StatusChecker\Domain\Event\EndpointSkipped;
use StatusChecker\Domain\Event\EndpointStatusChanged;

/**
 * Class MarkEndpointAsReachableHandler
 * @package StatusChecker\Application\Command\Handler
 */
class MarkEndpointAsReachableHandler
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
     * @param MarkEndpointAsReachable $command
     */
    public function __invoke(MarkEndpointAsReachable $command)
    {
        $endpoint = $this->endpoints->loadById($command->getId());

        if ($endpoint->getStatus() != EndpointStatus::PROCESSING()) {
            $this->eventBus->dispatch(
                new EndpointSkipped($endpoint->getId())
            );
        } else {
            $endpoint->markReachable($command->getHttpCode());
            $this->endpoints->save($endpoint);

            $this->eventBus->dispatch(
                new EndpointStatusChanged($endpoint->getId())
            );
        }
    }

}
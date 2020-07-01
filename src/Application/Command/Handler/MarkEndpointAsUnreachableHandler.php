<?php


namespace StatusChecker\Application\Command\Handler;


use StatusChecker\Application\Command\MarkEndpointAsUnreachable;
use StatusChecker\Application\EventBus;
use StatusChecker\Domain\Endpoints;
use StatusChecker\Domain\EndpointStatus;
use StatusChecker\Domain\Event\EndpointSkipped;
use StatusChecker\Domain\Event\EndpointStatusChanged;

/**
 * Class MarkEndpointAsUnreachableHandler
 * @package StatusChecker\Application\Command\Handler
 */
class MarkEndpointAsUnreachableHandler
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
     * @param MarkEndpointAsUnreachable $command
     */
    public function __invoke(MarkEndpointAsUnreachable $command)
    {
        $endpoint = $this->endpoints->loadById($command->getId());

        if ($endpoint->getStatus() != EndpointStatus::PROCESSING()) {
            $this->eventBus->dispatch(
                new EndpointSkipped($endpoint->getId())
            );
        } else {
            $endpoint->markUnreachable($command->getHttpCode());
            $this->endpoints->save($endpoint);

            $this->eventBus->dispatch(
                new EndpointStatusChanged($endpoint->getId())
            );
        }
    }

}
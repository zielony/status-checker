<?php


namespace StatusChecker\Application\Workflow;


use Prooph\Common\Messaging\DomainEvent;
use Psr\Log\LoggerInterface;
use StatusChecker\Application\Command\CheckEndpoint;
use StatusChecker\Application\Command\MarkEndpointAsFailed;
use StatusChecker\Application\Command\MarkEndpointAsReachable;
use StatusChecker\Application\Command\MarkEndpointAsUnreachable;
use StatusChecker\Application\Command\PrepareEndpoint;
use StatusChecker\Application\CommandBus;
use StatusChecker\Application\Workflow;
use StatusChecker\Domain\EndpointStatus;
use StatusChecker\Domain\Event\EndpointCheckFailed;
use StatusChecker\Domain\Event\EndpointNotReached;
use StatusChecker\Domain\Event\EndpointPrepared;
use StatusChecker\Domain\Event\EndpointReached;
use StatusChecker\Domain\Event\EndpointSkipped;
use StatusChecker\Domain\Event\EndpointStatusChanged;
use StatusChecker\Exception\UnsupportedWorkflowEvent;

/**
 * Class StandardWorkflow
 * @package StatusChecker\Application\Workflow
 */
class StandardWorkflow implements Workflow
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * StandardWorkflow constructor.
     * @param CommandBus $commandBus
     * @param LoggerInterface $logger
     */
    public function __construct(CommandBus $commandBus, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function start(): void
    {
        $this->logger->debug(
            'Starting...'
        );

        $this->commandBus->dispatch(
            new PrepareEndpoint(EndpointStatus::NEW())
        );
    }

    /**
     * @param EndpointPrepared $event
     */
    public function whenEndpointPrepared(EndpointPrepared $event)
    {
        $this->logger->debug(
            'Endpoint prepared, running check...',
            [
                'endpointId' => $event->getId(),
                'endpointUrl' => $event->getUrl()
            ]
        );

        $this->commandBus->dispatch(
            new CheckEndpoint($event->getId(), $event->getUrl())
        );
    }

    /**
     * @param EndpointReached $event
     */
    public function whenEndpointReached(EndpointReached $event)
    {
        $this->logger->debug(
            'Endpoint reached, saving...',
            [
                'endpointId' => $event->getId(),
                'endpointHttpCode' => $event->getHttpCode()
            ]
        );

        $this->commandBus->dispatch(
            new MarkEndpointAsReachable($event->getId(), $event->getHttpCode())
        );
    }

    /**
     * @param EndpointNotReached $event
     */
    public function whenEndpointNotReached(EndpointNotReached $event)
    {
        $this->logger->debug(
            'Endpoint not reached, saving...',
            [
                'endpointId' => $event->getId(),
                'endpointHttpCode' => $event->getHttpCode()
            ]
        );

        $this->commandBus->dispatch(
            new MarkEndpointAsUnreachable($event->getId(), $event->getHttpCode())
        );
    }

    /**
     * @param EndpointCheckFailed $event
     */
    public function whenEndpointCheckFailed(EndpointCheckFailed $event)
    {
        $this->logger->debug(
            'Endpoint check failed, saving...',
            [
                'endpointId' => $event->getId()
            ]
        );

        $this->commandBus->dispatch(
            new MarkEndpointAsFailed($event->getId())
        );
    }

    /**
     * @param EndpointStatusChanged $event
     */
    public function whenEndpointStatusChanged(EndpointStatusChanged $event)
    {
        $this->logger->debug(
            'Endpoint check done.',
            [
                'endpointId' => $event->getId()
            ]
        );

        $this->commandBus->dispatch(
            new PrepareEndpoint(EndpointStatus::NEW())
        );
    }

    /**
     * @param EndpointSkipped $event
     */
    public function whenEndpointSkipped(EndpointSkipped $event)
    {
        $this->logger->debug(
            'Endpoint skipped.',
            [
                'endpointId' => $event->getId()
            ]
        );

        $this->commandBus->dispatch(
            new PrepareEndpoint(EndpointStatus::NEW())
        );
    }

    /**
     * @param DomainEvent $event
     */
    public function __invoke(DomainEvent $event)
    {
        $eventClassName = $this->getEventClassName($event);

        if (method_exists($this, 'when' . $eventClassName)) {
            $this->{'when' . $eventClassName}($event);
        } else {
            throw UnsupportedWorkflowEvent::fromDomainEvent($event);
        }
    }

    /**
     * @return string[]
     */
    public function getSupportedEvents(): array
    {
        return [
            EndpointPrepared::class,
            EndpointReached::class,
            EndpointNotReached::class,
            EndpointCheckFailed::class,
            EndpointStatusChanged::class,
            EndpointSkipped::class
        ];
    }

    /**
     * @param DomainEvent $event
     * @return false|string
     */
    private function getEventClassName(DomainEvent $event)
    {
        $eventClassName = get_class($event);
        $namespaceDivPos = strrpos($eventClassName, '\\');
        if (false !== $namespaceDivPos) {
            $eventClassName = substr($eventClassName, $namespaceDivPos + 1);
        }

        return $eventClassName;
    }
}
<?php


namespace StatusChecker\Infrastructure;


use StatusChecker\Application\EventBus;

/**
 * Class ProophEventBusAdapter
 * @package StatusChecker\Infrastructure
 */
class ProophEventBusAdapter implements EventBus
{
    /**
     * @var \Prooph\ServiceBus\EventBus
     */
    protected $eventBus;

    /**
     * ProophEventBusAdapter constructor.
     * @param \Prooph\ServiceBus\EventBus $eventBus
     */
    public function __construct(\Prooph\ServiceBus\EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @return \Prooph\ServiceBus\EventBus
     */
    public function getEventBus(): \Prooph\ServiceBus\EventBus
    {
        return $this->eventBus;
    }

    /**
     * @param $message
     */
    public function dispatch($message): void
    {
        $this->eventBus->dispatch($message);
    }
}
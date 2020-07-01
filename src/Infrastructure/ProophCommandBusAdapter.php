<?php


namespace StatusChecker\Infrastructure;


use StatusChecker\Application\CommandBus;

/**
 * Class ProophCommandBusAdapter
 * @package StatusChecker\Infrastructure
 */
class ProophCommandBusAdapter implements CommandBus
{
    /**
     * @var \Prooph\ServiceBus\CommandBus
     */
    protected $commandBus;

    /**
     * ProophCommandBusAdapter constructor.
     * @param \Prooph\ServiceBus\CommandBus $commandBus
     */
    public function __construct(\Prooph\ServiceBus\CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @return \Prooph\ServiceBus\CommandBus
     */
    public function getCommandBus(): \Prooph\ServiceBus\CommandBus
    {
        return $this->commandBus;
    }

    /**
     * @param mixed $command
     */
    public function dispatch($command): void
    {
        $this->commandBus->dispatch($command);
    }
}
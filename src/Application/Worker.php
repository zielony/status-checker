<?php


namespace StatusChecker\Application;

/**
 * Class Worker
 * @package StatusChecker\Application
 */
final class Worker
{

    /**
     * @var Workflow
     */
    private $workflow;

    /**
     * Worker constructor.
     * @param Workflow $workflow
     */
    public function __construct(Workflow $workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * Starts the workflow passed in the constructor
     */
    public function start(): void
    {
        $this->workflow->start();
    }
}
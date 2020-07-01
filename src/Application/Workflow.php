<?php


namespace StatusChecker\Application;

/**
 * Interface Workflow
 * @package StatusChecker\Application
 */
interface Workflow
{
    /**
     * Starts the workflow
     */
    public function start(): void;
}
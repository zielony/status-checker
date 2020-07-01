<?php

namespace StatusChecker\Application;


interface CommandBus
{
    /**
     * @param mixed $command
     *
     */
    public function dispatch($command): void;
}
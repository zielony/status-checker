<?php

namespace StatusChecker\Application;


interface EventBus
{
    /**
     * @param $message
     */
    public function dispatch($message): void;
}
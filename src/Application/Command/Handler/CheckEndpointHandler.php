<?php

namespace StatusChecker\Application\Command\Handler;

use StatusChecker\Application\Command\CheckEndpoint;
use StatusChecker\Application\EventBus;
use StatusChecker\Domain\Event\EndpointCheckFailed;
use StatusChecker\Domain\Event\EndpointNotReached;
use StatusChecker\Domain\Event\EndpointReached;
use StatusChecker\Domain\HttpCodeChecker;
use StatusChecker\Exception\HttpCodeCheckFailed;

/**
 * Class CheckEndpointHandler
 * @package StatusChecker\Application\Command\Handler
 */
class CheckEndpointHandler
{
    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @var HttpCodeChecker
     */
    private $checker;

    /**
     * CheckEndpointHandler constructor.
     * @param EventBus $eventBus
     * @param HttpCodeChecker $checker
     */
    public function __construct(EventBus $eventBus, HttpCodeChecker $checker)
    {
        $this->eventBus = $eventBus;
        $this->checker = $checker;
    }

    /**
     * @param CheckEndpoint $command
     */
    public function __invoke(CheckEndpoint $command)
    {
        try {
            $code = $this->checker->checkHttpCodeForUrl($command->getUrl());

            if ($code >= 200 && $code <= 310) {
                $this->eventBus->dispatch(
                    new EndpointReached($command->getId(), $code)
                );
            } else {
                $this->eventBus->dispatch(
                    new EndpointNotReached($command->getId(), $code)
                );
            }
        } catch (HttpCodeCheckFailed $exception) {
            $this->eventBus->dispatch(
                new EndpointCheckFailed($command->getId())
            );
        }
    }

}
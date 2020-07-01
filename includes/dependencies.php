<?php

use Monolog\Handler\StreamHandler;
use Monolog\Processor\ProcessIdProcessor;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use StatusChecker\Application\Command\CheckEndpoint;
use StatusChecker\Application\Command\Handler\CheckEndpointHandler;
use StatusChecker\Application\Command\Handler\MarkEndpointAsFailedHandler;
use StatusChecker\Application\Command\Handler\MarkEndpointAsReachableHandler;
use StatusChecker\Application\Command\Handler\MarkEndpointAsUnreachableHandler;
use StatusChecker\Application\Command\Handler\PrepareEndpointHandler;
use StatusChecker\Application\Command\MarkEndpointAsFailed;
use StatusChecker\Application\Command\MarkEndpointAsReachable;
use StatusChecker\Application\Command\MarkEndpointAsUnreachable;
use StatusChecker\Application\Command\PrepareEndpoint;
use StatusChecker\Application\Workflow\StandardWorkflow;
use StatusChecker\Infrastructure\GuzzleHttpCodeChecker;
use StatusChecker\Infrastructure\ProophCommandBusAdapter;
use StatusChecker\Infrastructure\ProophEventBusAdapter;
use StatusChecker\Infrastructure\Repository\EndpointsInMysql;

// db repository in mysql
$endpoints = new EndpointsInMysql('db', 'statcheck', 'user', 'test');

// HTTP checker with Guzzle
$httpCodeChecker = new GuzzleHttpCodeChecker();

// event&command buses with Prooph
$eventBus = new ProophEventBusAdapter(new \Prooph\ServiceBus\EventBus());
$eventRouter = new EventRouter();
$eventRouter->attachToMessageBus($eventBus->getEventBus());

$commandBus = new ProophCommandBusAdapter(new \Prooph\ServiceBus\CommandBus());
$commandRouter = new CommandRouter();
$commandRouter->attachToMessageBus($commandBus->getCommandBus());

// custom commands handlers
$commandRouter->route(PrepareEndpoint::class)
    ->to(new PrepareEndpointHandler($endpoints, $eventBus));
$commandRouter->route(CheckEndpoint::class)
    ->to(new CheckEndpointHandler($eventBus, $httpCodeChecker));
$commandRouter->route(MarkEndpointAsFailed::class)
    ->to(new MarkEndpointAsFailedHandler($endpoints, $eventBus));
$commandRouter->route(MarkEndpointAsReachable::class)
    ->to(new MarkEndpointAsReachableHandler($endpoints, $eventBus));
$commandRouter->route(MarkEndpointAsUnreachable::class)
    ->to(new MarkEndpointAsUnreachableHandler($endpoints, $eventBus));

// logger with Monolog
$logger = new \Monolog\Logger('demo');
$logger->pushHandler(new StreamHandler('php://stdout'));
$logger->pushProcessor(
    new ProcessIdProcessor()
);

// custom workflow (+ events routing)
$workflow = new StandardWorkflow($commandBus, $logger);
foreach ($workflow->getSupportedEvents() as $event) {
    $eventRouter->route($event)->to($workflow);
}
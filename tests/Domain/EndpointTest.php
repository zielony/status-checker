<?php

namespace Domain;

use StatusChecker\Domain\Endpoint;
use PHPUnit\Framework\TestCase;
use StatusChecker\Domain\EndpointStatus;
use StatusChecker\Exception\InvalidEndpointStatusTransition;

class EndpointTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testMarkReachable()
    {
        // happy path
        $endpoint = new Endpoint(1, 'https://example.com', EndpointStatus::PROCESSING());
        $endpoint->markReachable(200);

        $this->assertEquals(EndpointStatus::DONE(), $endpoint->getStatus());
        $this->assertEquals(200, $endpoint->getHttpCode());

        // illegal state transition
        $this->expectExceptionObject(
            InvalidEndpointStatusTransition::fromEndpointStatuses(EndpointStatus::NEW(), EndpointStatus::DONE())
        );

        $endpoint = new Endpoint(2, 'https://example.com', EndpointStatus::NEW());
        $endpoint->markReachable(200);
    }

    public function testPrepare()
    {
        // happy path
        $endpoint = new Endpoint(1, 'https://example.com', EndpointStatus::NEW());
        $endpoint->prepare();

        $this->assertEquals(EndpointStatus::PROCESSING(), $endpoint->getStatus());
        $this->assertNull($endpoint->getHttpCode());

        // illegal state transition
        $this->expectExceptionObject(
            InvalidEndpointStatusTransition::fromEndpointStatuses(EndpointStatus::PROCESSING(), EndpointStatus::PROCESSING())
        );

        $endpoint = new Endpoint(2, 'https://example.com', EndpointStatus::PROCESSING());
        $endpoint->prepare();
    }

    public function testMarkUnreachable()
    {
        // happy path
        $endpoint = new Endpoint(1, 'https://example.com', EndpointStatus::PROCESSING());
        $endpoint->markUnreachable(404);

        $this->assertEquals(EndpointStatus::DONE(), $endpoint->getStatus());
        $this->assertEquals(404, $endpoint->getHttpCode());

        // illegal state transition
        $this->expectExceptionObject(
            InvalidEndpointStatusTransition::fromEndpointStatuses(EndpointStatus::NEW(), EndpointStatus::DONE())
        );

        $endpoint = new Endpoint(2, 'https://example.com', EndpointStatus::NEW());
        $endpoint->markUnreachable(404);
    }

    public function testMarkFailed()
    {
        // happy path
        $endpoint = new Endpoint(1, 'https://example.com', EndpointStatus::PROCESSING());
        $endpoint->markFailed();

        $this->assertEquals(EndpointStatus::ERROR(), $endpoint->getStatus());
        $this->assertNull($endpoint->getHttpCode());

        // illegal state transition
        $this->expectExceptionObject(
            InvalidEndpointStatusTransition::fromEndpointStatuses(EndpointStatus::NEW(), EndpointStatus::ERROR())
        );

        $endpoint = new Endpoint(2, 'https://example.com', EndpointStatus::NEW());
        $endpoint->markFailed();
    }
}

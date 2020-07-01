<?php

use StatusChecker\Exception\EntityNotFound;
use StatusChecker\Application\Worker;

// include composer autoloader
require_once './vendor/autoload.php';

// include necessary dependencies
require_once './includes/dependencies.php';

try {
    // create and start worker
    $worker = new Worker($workflow);
    $worker->start();
} catch(\Exception $exception) {
    while(!empty($exception->getPrevious())) {
        $exception = $exception->getPrevious();
    }

    if($exception instanceof EntityNotFound) {
        $logger->info('No more endpoints to check');
    } else {
        $logger->error(
            'Core exception caught!',
            [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]
        );
    }
}
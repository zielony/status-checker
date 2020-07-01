<?php


namespace StatusChecker\Domain;


use MyCLabs\Enum\Enum;

/**
 * Class EndpointStatus
 * @package StatusChecker\Domain
 *
 * @method static self NEW()
 * @method static self PROCESSING()
 * @method static self DONE()
 * @method static self ERROR()
 */
class EndpointStatus extends Enum
{
    public const NEW = 'new';
    public const PROCESSING = 'processing';
    public const DONE = 'done';
    public const ERROR = 'error';
}
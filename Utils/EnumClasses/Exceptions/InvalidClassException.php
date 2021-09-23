<?php

namespace Utils\EnumClasses\Exceptions;

use Exception;
use Throwable;

/**
 * Class InvalidClassException
 * @package Utils\EnumClasses\Exceptions
 */
final class InvalidClassException extends Exception
{
    public function __construct(string $invalidClass, Throwable $previous = null)
    {
        parent::__construct("The class * {$invalidClass} * is not an enum", 0, $previous);
    }
}
<?php
declare(strict_types=1);


namespace Utils\EnumClasses\Exceptions;

use Exception;
use Throwable;

/**
 * Class InvalidValueException
 * @package Utils\EnumClasses\Exceptions
 */
final class InvalidValueException extends Exception
{
    public function __construct(string $invalidValue, array $validValues, Throwable $previous = null)
    {
        parent::__construct("Invalid value: * {$invalidValue} *. Valids: " . implode(", ", $validValues), 0, $previous);
    }
}
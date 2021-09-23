<?php

namespace Utils\VariablesExtractor\Exceptions;

use Exception;
use Throwable;

/**
 * Class InvalidVariableClosure
 * @package Utils\VariablesExtractor\Exceptions
 */
final class InvalidVariableClosure extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct("There is a variable with an invalid closure", 0, $previous);
    }
}
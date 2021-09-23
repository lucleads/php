<?php

namespace Utils\EnumClasses;

use Utils\EnumClasses\ValueObjects\StringValue;

/**
 * Class Enum
 * @package Utils\EnumClasses
 */
abstract class Enum extends StringValue
{
    /**
     * is
     * @param string|null ...$value
     * @return bool
     */
    public function is(?string ...$value): bool
    {
        return in_array($this, $value);
    }

    /**
     * isNot
     * @param string|null ...$value
     * @return bool
     */
    public function isNot(?string ...$value): bool
    {
        return !in_array($this, $value);
    }
}
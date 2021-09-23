<?php
declare(strict_types=1);


namespace Utils\EnumClasses\ValueObjects;

/**
 * Class StringValue
 * @package Ngcs\Core\ValueObjects
 */
abstract class StringValue
{
    private string $value;

    /**
     * StringValue constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

}
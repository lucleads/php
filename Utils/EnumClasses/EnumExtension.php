<?php

namespace Utils\EnumClasses;

use ReflectionClass;
use ReflectionException;
use Utils\EnumClasses\Exceptions\InvalidClassException;
use Utils\EnumClasses\Exceptions\InvalidValueException;

/**
 * Class EnumExtension
 * @package Utils\EnumClasses
 */
abstract class EnumExtension
{
    private string $value;

    /**
     * @throws ReflectionException
     * @throws InvalidValueException
     * @throws InvalidClassException
     */
    public function __construct(string $value, string $className)
    {
        $this->value = $value;
        $validValues = $this->getValidValues($className);
        $isAValidValueInEnum = $this->checkValid($validValues);
        if (!$isAValidValueInEnum) {
            throw new InvalidValueException($value, $validValues);
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * is
     * @param string|null ...$value
     * @return bool
     */
    public function is(?string ...$value): bool
    {
        return in_array($this->value, $value);
    }

    /**
     * isNot
     * @param string|null ...$value
     * @return bool
     */
    public function isNot(?string ...$value): bool
    {
        return !in_array($this->value, $value);
    }

    /**
     * checkValid
     * @param array $validValues
     * @return bool
     */
    private function checkValid(array $validValues): bool
    {
        return in_array($this->value, $validValues);
    }

    /**
     * getValidValues
     * @param string $className
     * @return array
     * @throws ReflectionException
     * @throws InvalidClassException
     */
    private function getValidValues(string $className): array
    {
        $r = new ReflectionClass($className);
        if (empty($r)) {
            throw new InvalidClassException($className);
        }
        return $this->getConstants($r);
    }

    /**
     * getConstants
     * @param ReflectionClass $r
     * @return array
     */
    private function getConstants(ReflectionClass $r): array
    {
        return array_values($r->getConstants());
    }
}
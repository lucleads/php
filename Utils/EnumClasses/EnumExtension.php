<?php

namespace Utils\EnumClasses;

use Utils\EnumClasses\ValueObjects\StringValue;
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
    /**
     * @throws ReflectionException
     * @throws InvalidValueException
     * @throws InvalidClassException
     */
    public function __construct(string $value, string $className)
    {
        parent::__construct($value);
        $validValues = $this->getValidValues($className);
        $isAValidValueInEnum = $this->checkValid($validValues);
        if (!$isAValidValueInEnum) {
            throw new InvalidValueException($value, $validValues);
        }
    }

    /**
     * is
     * @param string|null ...$value
     * @return bool
     */
    public function is(?string ...$value): bool
    {
        return in_array($this->getValue(), $value);
    }

    /**
     * isNot
     * @param string|null ...$value
     * @return bool
     */
    public function isNot(?string ...$value): bool
    {
        return !in_array($this->getValue(), $value);
    }

    /**
     * checkValid
     * @param array $validValues
     * @return bool
     */
    private function checkValid(array $validValues): bool
    {
        return in_array($this->getValue(), $validValues);
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

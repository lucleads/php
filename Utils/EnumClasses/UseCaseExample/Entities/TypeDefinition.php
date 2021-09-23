<?php
declare(strict_types=1);


namespace Utils\EnumClasses\UseCaseExample\Entities;

use InvalidArgumentException;
use Utils\EnumClasses\TypeEnum;
use Utils\EnumClasses\UseCaseExample\Entities\ValueObjects\Type;

/**
 * Class TypeDefinition
 * @package Utils\EnumClasses\UseCaseExample\Entities
 */
abstract class TypeDefinition
{
    private Type $type;
    private string $strProperty;
    private int $intProperty;

    /**
     * @param Type $type
     * @param string|null $strProperty
     * @param int|null $intProperty
     */
    public function __construct(Type $type, ?string $strProperty, ?int $intProperty)
    {
        $this->checkConditions($type, $strProperty, $intProperty);
        $this->type = $type;
        $this->strProperty = $strProperty;
        $this->intProperty = $intProperty;
    }

    /**
     * checkConditions
     * @param Type $type
     * @param string|null $strProperty
     * @param int|null $intProperty
     */
    private function checkConditions(Type $type, ?string $strProperty, ?int $intProperty): void
    {
        if ($type->is(TypeEnum::TYPE_1) && is_null($strProperty)) {
            throw new InvalidArgumentException("If type is 1, strProperty cannot be null");
        }

        if ($type->is(TypeEnum::TYPE_2) && is_null($intProperty)) {
            throw new InvalidArgumentException("If type is 2, intProperty cannot be null");
        }
    }
}
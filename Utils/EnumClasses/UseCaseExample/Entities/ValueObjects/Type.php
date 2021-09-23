<?php
declare(strict_types=1);


namespace Utils\EnumClasses\UseCaseExample\Entities\ValueObjects;


use Utils\EnumClasses\EnumExtension;
use Utils\EnumClasses\TypeEnum;

/**
 * Class Type
 * @package Utils\EnumClasses\UseCaseExample\Entities\ValueObjects
 */
final class Type extends EnumExtension
{
    public function __construct(string $value)
    {
        parent::__construct($value, TypeEnum::class);
    }
}
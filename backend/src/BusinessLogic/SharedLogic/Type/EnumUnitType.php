<?php

namespace App\BusinessLogic\SharedLogic\Type;

use App\BusinessLogic\SharedLogic\Model\EnumTypeName;
use App\BusinessLogic\SharedLogic\Model\UnitType;

/**
 * Class EnumUnitType.
 */
class EnumUnitType extends AbstractEnumType
{
    /** @var string */
    protected $name = EnumTypeName::UNIT_TYPE;

    /**
     * @return array
     */
    public function getValues(): array
    {
        return UnitType::values();
    }
}

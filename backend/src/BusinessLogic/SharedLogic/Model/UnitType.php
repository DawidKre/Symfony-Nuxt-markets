<?php

namespace App\BusinessLogic\SharedLogic\Model;

use MyCLabs\Enum\Enum;

/**
 * Class UnitType
 */
class UnitType extends Enum
{
    public const KILO = 'KILO';

    public const PIECE = 'PIECE';

    public const BUNCH = 'BUNCH';

    public const GRAMS = 'GRAMS';

    public const LITER = 'LITER';

    public const MILLILITERS = 'MILLILITERS';
}

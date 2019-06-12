<?php

namespace App\BusinessLogic\SharedLogic\Model;

use MyCLabs\Enum\Enum;

class UnitType extends Enum
{
    const KILO = 'KILO';

    const PIECE = 'PIECE';

    const BUNCH = 'BUNCH';

    const GRAMS = 'GRAMS';

    const LITER = 'LITER';

    const MILLILITERS = 'MILLILITERS';
}

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

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function getUnitTypeByString($name): string
    {
        $unitTypes = [
            'kg' => self::KILO,
            'pęczek' => self::BUNCH,
            'szt' => self::PIECE,
            'g' => self::GRAMS,
            'l' => self::LITER,
            'ml' => self::MILLILITERS,
        ];

        return $unitTypes[$name];
    }


}

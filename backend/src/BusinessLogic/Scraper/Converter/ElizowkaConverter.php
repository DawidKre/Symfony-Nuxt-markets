<?php

namespace App\BusinessLogic\Scraper\Converter;

use App\BusinessLogic\Scraper\Model\Unit;
use App\BusinessLogic\SharedLogic\Model\UnitType;

/**
 * Class ElizowkaConverter.
 */
class ElizowkaConverter implements ConverterInterface
{
    /**
     * @var Unit
     */
    private $unit;

    /**
     * ImportService constructor.
     *
     * @param Unit $unit
     */
    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @param string $unitsString
     *
     * @return Unit
     */
    public function convertUnits(string $unitsString): Unit
    {
        $convertedString = explode(' ', $unitsString);
        if (count($convertedString) > 1) {
            $this->unit->setUnit(UnitType::getUnitTypeByString($convertedString[1]));
            $this->unit->setQuantity($convertedString[0]);
            $this->unit->setAmount(1);
        } else {
            $this->unit->setUnit(UnitType::getUnitTypeByString($convertedString[0]));
            $this->unit->setQuantity(1);
            $this->unit->setAmount(1);
        }

        return $this->unit;
    }

    /**
     * @return mixed
     */
    public function convert()
    {
        // TODO: Implement convert() method.
    }
}

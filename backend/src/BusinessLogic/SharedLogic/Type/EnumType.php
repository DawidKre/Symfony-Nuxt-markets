<?php

namespace App\BusinessLogic\SharedLogic\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

abstract class EnumType extends Type
{
    protected $name;

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $this->getName();
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value !== null && !in_array($value, $this->getValues(), true)) {
            throw new InvalidArgumentException("Invalid '" . $this->getName() . "' value.");
        }
        return $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    abstract public function getValues(): array;
}

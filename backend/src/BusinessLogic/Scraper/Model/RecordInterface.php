<?php

namespace App\BusinessLogic\Scraper\Model;

/**
 * Class Record
 */
interface RecordInterface
{
    public function getAsArray(): array;

    public function getParametersAsArray(): array;
}

<?php

namespace App\BusinessLogic\Scraper\Model;

/**
 * Class Record
 */
interface RecordInterface
{
    /**
     * @return array
     */
    public function getAsArray(): array;

    /**
     * @return array
     */
    public function getParametersAsArray(): array;
}

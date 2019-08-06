<?php

namespace App\BusinessLogic\Importer\Model;

/**
 * Class ImporterStatus.
 */
class ImporterStatus
{
    public const IMPORTER_START_IMPORTING = 'Start importing';

    public const IMPORTER_MARKET_FINISHED_IMPORTING = 'Finished market importing';

    public const IMPORTER_FINISHED_IMPORTING = 'Finished importing';

    public const IMPORTER_ERROR_FOUND = '!!! Error';
}

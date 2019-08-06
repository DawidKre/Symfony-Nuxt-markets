<?php

namespace App\BusinessLogic\Importer\Command;

use App\BusinessLogic\Importer\Service\ImportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ScrapeMarketsCommand.php.
 */
class ImportPricesCommand extends Command
{
    protected static $defaultName = 'import:prices';

    /** @var ImportService */
    private $importService;

    /**
     * ScrapeMarketsCommand constructor.
     *
     * @param ImportService $importService
     */
    public function __construct(ImportService $importService)
    {
        parent::__construct();
        $this->importService = $importService;
    }

    protected function configure(): void
    {
        $this->setDescription('Method which execute scraping process');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->importService->startImporter();
    }
}

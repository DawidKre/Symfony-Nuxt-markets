<?php

namespace App\BusinessLogic\Importer\Command;

use App\BusinessLogic\Importer\Service\ImportService;
use App\Entity\ImporterLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ScrapeMarketsCommand.php.
 */
class ImportPricesCommand extends Command
{
    protected static $defaultName = 'import:prices';

    /** @var ImportService */
    private $importService;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /**
     * ScrapeMarketsCommand constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param ImportService            $importService
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ImportService $importService,
        EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct();
        $this->importService = $importService;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    protected function configure(): void
    {
        $this->setDescription('Method which execute scraping process');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \League\Csv\Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $importerLogs = $this->entityManager->getRepository(ImporterLog::class)->getNotImported();

        foreach ($importerLogs as $importerLog) {
            $this->importService->import($importerLog);
        }
    }
}

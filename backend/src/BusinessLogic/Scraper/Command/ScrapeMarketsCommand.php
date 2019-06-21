<?php

namespace App\BusinessLogic\Scraper\Command;

use App\BusinessLogic\Scraper\Exception\ScraperException;
use App\BusinessLogic\Scraper\Service\ScraperManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ScrapeMarketsCommand
 */
class ScrapeMarketsCommand extends Command
{
    protected static $defaultName = 'scrape:markets';

    /** @var ScraperManager */
    private $scraperManager;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ScrapeMarketsCommand constructor.
     * @param ScraperManager  $scraperManager
     * @param LoggerInterface $scraperLogger
     */
    public function __construct(ScraperManager $scraperManager, LoggerInterface $scraperLogger)
    {
        parent::__construct();

        $this->scraperManager = $scraperManager;
        $this->logger = $scraperLogger;
    }

    protected function configure(): void
    {
        $this->setDescription('Method which execute scraping process');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger->info('Start scrapping');

        try {
            $this->scraperManager->scrapeMarkets();
            $this->logger->notice('Scraping finished');
        } catch (ScraperException $e) {
            $this->logger->error('CannotInsertRecord: '.$e->getMessage(), [
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}

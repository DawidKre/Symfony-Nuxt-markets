<?php

namespace App\BusinessLogic\Scraper\Command;

use App\BusinessLogic\Scraper\Service\ScraperManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
     * ScrapeMarketsCommand constructor.
     * @param ScraperManager $scraperManager
     */
    public function __construct(ScraperManager $scraperManager)
    {
        parent::__construct();

        $this->scraperManager = $scraperManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     *
     * @throws \League\Csv\CannotInsertRecord
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->progressStart(1);
        $this->scraperManager->scrapeMarkets();
        $io->progressFinish();
    }
}

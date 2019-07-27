<?php

namespace App\BusinessLogic\Scraper\Command;

use App\BusinessLogic\Scraper\Event\MarketNotScrapedEvent;
use App\BusinessLogic\Scraper\Event\MarketScrapedEvent;
use App\BusinessLogic\Scraper\Event\MarketScrapingErrorEvent;
use App\BusinessLogic\Scraper\Event\ScrapingProcessFinishedEvent;
use App\BusinessLogic\Scraper\Event\ScrapingProcessStartedEvent;
use App\BusinessLogic\Scraper\Exception\MarketNotScrapedException;
use App\BusinessLogic\Scraper\Exception\ScraperException;
use App\BusinessLogic\Scraper\Factory\ScrapeMarketFactory;
use App\Entity\Market;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\CannotInsertRecord;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ScrapeMarketsCommand.
 */
class ScrapeMarketsCommand extends Command
{
    protected static $defaultName = 'scrape:markets';

    /** @var ScrapeMarketFactory */
    private $scraperManager;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /**
     * ScrapeMarketsCommand constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param ScrapeMarketFactory      $scraperManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EntityManagerInterface $entityManager, ScrapeMarketFactory $scraperManager, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct();
        $this->scraperManager = $scraperManager;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return void
     */
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
        $this->eventDispatcher->dispatch(new ScrapingProcessStartedEvent());
        $markets = $this->entityManager->getRepository(Market::class)->findAll();

        foreach ($markets as $market) {
            try {
                $records = $this->scraperManager->createScraper($market)->scrapeMarket();
                $this->eventDispatcher->dispatch(new MarketScrapedEvent($market, $records));
            } catch (MarketNotScrapedException $e) {
                $this->eventDispatcher->dispatch(new MarketNotScrapedEvent($market, $e->getMessage()));
            } catch (ScraperException $e) {
                $this->eventDispatcher->dispatch(new MarketScrapingErrorEvent($market, $e->getMessage()));
            } catch (CannotInsertRecord $e) {
                $this->eventDispatcher->dispatch(new MarketScrapingErrorEvent($market, $e->getMessage()));
            }
        }

        $this->eventDispatcher->dispatch(new ScrapingProcessFinishedEvent());
    }
}

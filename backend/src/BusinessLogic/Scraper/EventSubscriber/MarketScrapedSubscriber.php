<?php

namespace App\BusinessLogic\Scraper\EventSubscriber;

use App\BusinessLogic\Scraper\Event\MarketNotScrapedEvent;
use App\BusinessLogic\Scraper\Event\MarketScrapedEvent;
use App\BusinessLogic\Scraper\Event\MarketScrapingErrorEvent;
use App\BusinessLogic\Scraper\Service\ScraperLogService;
use App\BusinessLogic\SharedLogic\Service\SlackService;
use App\Entity\Market;
use Http\Client\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateMarketScraperCheckSubscriber.
 */
class MarketScrapedSubscriber implements EventSubscriberInterface
{
    /** @var SlackService */
    private $slackService;

    /** @var ScraperLogService */
    private $scraperLogService;

    /**
     * MarketScrapedSubscriber constructor.
     *
     * @param SlackService      $slackService
     * @param ScraperLogService $scraperLogService
     */
    public function __construct(SlackService $slackService, ScraperLogService $scraperLogService)
    {
        $this->slackService = $slackService;
        $this->scraperLogService = $scraperLogService;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            MarketScrapedEvent::class => 'onMarketScraped',
            MarketNotScrapedEvent::class => 'onMarketNotScraped',
            MarketScrapingErrorEvent::class => 'onMarketScrapingError',
        ];
    }

    /**
     * @param MarketScrapedEvent $event
     *
     * @throws Exception
     */
    public function onMarketScraped(MarketScrapedEvent $event): void
    {
        $this->marketScraped($event->getMarket(), $event->getFileName());
    }

    /**
     * @param MarketNotScrapedEvent $event
     *
     * @throws Exception
     */
    public function onMarketNotScraped(MarketNotScrapedEvent $event): void
    {
        $this->marketNotScraped($event->getMarket());
    }

    /**
     * @param MarketScrapingErrorEvent $event
     *
     * @throws Exception
     */
    public function onMarketScrapingError(MarketScrapingErrorEvent $event): void
    {
        $this->marketScrapingError($event->getMarket(), $event->getErrorMessage());
    }

    /**
     * @param Market $market
     * @param string $fileName
     *
     * @throws Exception
     */
    public function marketScraped(Market $market, string $fileName): void
    {
        $this->slackService->sendScraperStartScrapingMessage($market->getName());
        $this->scraperLogService->saveSuccessScraperLog($market, $fileName);
    }

    /**
     * @param Market $market
     *
     * @throws Exception
     */
    public function marketNotScraped(Market $market): void
    {
        $this->slackService->sendScraperChangesNotFoundMessage($market->getName());
    }

    /**
     * @param Market $market
     * @param string $errorMessage
     *
     * @throws Exception
     */
    public function marketScrapingError(Market $market, string $errorMessage): void
    {
        $this->scraperLogService->saveFailedScraperLog($market, $errorMessage);
        $this->slackService->sendErrorMessage($market->getName(), $errorMessage);
    }
}

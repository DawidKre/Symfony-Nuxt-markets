<?php

namespace App\Controller;

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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ScraperController.
 */
class ScraperController extends AbstractController
{
    /**
     * @Route("/scraper", name="scraper")
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param ScrapeMarketFactory      $scraperManager
     * @param EntityManagerInterface   $entityManager
     *
     * @return JsonResponse
     */
    public function index(EventDispatcherInterface $eventDispatcher, ScrapeMarketFactory $scraperManager, EntityManagerInterface $entityManager): Response
    {
        $eventDispatcher->dispatch(new ScrapingProcessStartedEvent());
        $markets = $entityManager->getRepository(Market::class)->findAll();

        foreach ($markets as $market) {
            try {
                $records = $scraperManager->createScraper($market)->scrapeMarket();
                $eventDispatcher->dispatch(new MarketScrapedEvent($market, $records));
            } catch (MarketNotScrapedException $e) {
                $eventDispatcher->dispatch(new MarketNotScrapedEvent($market, $e->getMessage()));
            } catch (ScraperException $e) {
                $eventDispatcher->dispatch(new MarketScrapingErrorEvent($market, $e->getMessage()));
            } catch (CannotInsertRecord $e) {
                $eventDispatcher->dispatch(new MarketScrapingErrorEvent($market, $e->getMessage()));
            }
        }

        $eventDispatcher->dispatch(new ScrapingProcessFinishedEvent());

        return $this->render('scraper/index.html.twig');
    }

    /**
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function home(): Response
    {
        return $this->redirect('/api');
    }
}

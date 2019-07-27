<?php

namespace App\Controller;

use App\BusinessLogic\Scraper\Exception\MarketNotScrapedException;
use App\BusinessLogic\Scraper\Exception\ScraperException;
use App\BusinessLogic\Scraper\Factory\ScrapeMarketFactory;
use App\Entity\Market;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ScraperController.
 */
class ScraperController extends AbstractController
{
    /**
     * @Route("/scraper", name="sraper")
     *
     * @param ScrapeMarketFactory $scrapeMarketFactory
     *
     * @return JsonResponse
     *
     * @throws MarketNotScrapedException
     * @throws ScraperException
     */
    public function index(ScrapeMarketFactory $scrapeMarketFactory): JsonResponse
    {
        $markets = $this->getDoctrine()->getRepository(Market::class)->findAll();

        foreach ($markets as $market) {
            $scrapeMarketFactory->createScraper($market)->scrapeMarket();
        }

        return new JsonResponse(['status' => 'success']);
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

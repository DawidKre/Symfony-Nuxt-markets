<?php

namespace App\Controller;

use App\BusinessLogic\Scraper\Factory\ScrapeMarketFactory;
use App\Entity\Market;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScraperController extends AbstractController
{
    /**
     * @Route("/scraper", name="sraper")
     *
     * @param ScrapeMarketFactory $scrapeMarketFactory
     *
     * @return Response
     */
    public function index(ScrapeMarketFactory $scrapeMarketFactory): Response
    {
        $markets = $this->getDoctrine()->getRepository(Market::class)->findAll();

        foreach ($markets as $market) {
            $scrapeMarketFactory->createScraper($market)->scrapeMarket();
        }

        return new Response(['200']);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->redirect('/api');
    }
}
